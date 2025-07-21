/**
 * Modernized WPT Control JavaScript
 * Converted to modular ES6+ object style
 */

(function($) {
    'use strict';

    const WPTControl = {
        // State & config
        state: {
            ownFragmentLoad: 0,
            paginatedVal: 0,
            resetSearchClicked: 'no',
            wcFragmentLoad: 0,
            fragmentHandleLoad: 0,
            isMob: false,
            isDesk: false,
            currentWidth: $(window).width(),
        },
        config: {
            pluginUrl: WPT_DATA.plugin_url,
            includeUrl: WPT_DATA.include_url,
            contentUrl: WPT_DATA.content_url,
            ajaxUrl: WPT_DATA.ajax_url,
            siteUrl: WPT_DATA.site_url,
            nonce: WPT_DATA.nonce,
        },

        // Init function
        init: function() {
            this.state.currentWidth = $(window).width();
            if (this.state.currentWidth <= 500) {
                this.state.isMob = true;
                this.state.isDesk = false;
                this.genDeskToMobTable();
            } else {
                this.state.isMob = false;
                this.state.isDesk = true;
                this.genMobToDeskTable();
            }
            $(window).on('resize', () => this.deviceWiseResize());
            this.bindEvents();
            $(document.body).append('<div class="wpt-new-footer-cart footer-cart-empty"></div>');
        },

        bindEvents: function() {
            const self = this;

            $(document.body).on('click', '.wpt_pagination_ajax .wpt_my_pagination a', function(e) {
                e.preventDefault();
                self.handlePaginationClick($(this));
            });

            $(document.body).on('click', 'button.button.wpt_load_more', function(e) {
                e.preventDefault();
                self.handleLoadMore($(this));
            });

            $(document.body).on('click', '.wpt-search-products', function() {
                self.handleSearchProducts($(this));
            });

            $(document.body).on('click', '.wpt-query-reset-button', function() {
                self.handleResetSearch($(this));
            });

            $(document).on('wc_fragments_refreshed wc_fragments_refresh wc_fragment_refresh removed_from_cart wpt_fragment_load', function() {
                self.fragmentLoad();
            });

            $(document.body).on('wpt_ajax_loaded', function() {
                self.state.paginatedVal = 0;
                $('.wpt_varition_section.variations').change();
            });

            $(document.body).on('click', '.wpt-cart-remove', function() {
                self.handleCartRemove($(this));
            });

            $(document.body).on('click', '.wpt_empty_cart_btn', function(e) {
                e.preventDefault();
                self.handleEmptyCart();
            });

            $(document.body).on('click', '.wpt-fcart-coll-expand,.wpt-cart-contents span.count', function() {
                self.toggleFooterCart();
            });

            $(document.body).on('mouseover', '.wpt-new-footer-cart.wpt-foooter-cart-stats-on a.wpt-view-n', function() {
                self.toggleFooterCartHover();
            });

            $(document.body).on('click', '.caqv-open-modal-notfound', function() {
                alert('Quick View by CodeAstrology plugin is required.\nPlease Install and Activate it.\nPlugin will load on new tab.');
                window.open('https://wordpress.org/plugins/ca-quick-view/', '_blank');
            });

            $(window).scroll(function() {
                self.handleInfiniteScroll();
            });
        },

        handlePaginationClick: function($el) {
            const thisPagination = $el.closest('.wpt_my_pagination');
            const page_number = parseInt($el.text().replace(/,/g, ''), 10);
            const table_id = thisPagination.data('table_id');
            const args = this.getSearchQueriedArgs(table_id);
            this.ajaxTableLoad(table_id, args, { page_number, isMob: this.state.isMob });
        },

        handleLoadMore: function($btn) {
            const table_id = $btn.data('table_id');
            $btn.html($btn.data('text_loading'));
            const page_number = $btn.attr('data-page_number');
            const args = this.getSearchQueriedArgs(table_id);
            this.ajaxTableLoad(table_id, args, { page_number, isMob: this.state.isMob, type: 'load_more' });
        },

        handleSearchProducts: function($btn) {
            const table_id = $btn.data('table_id');
            const args = this.getSearchQueriedArgs(table_id);
            this.ajaxTableLoad(table_id, args, { page_number: 1, isMob: this.state.isMob });
        },

        handleResetSearch: function($btn) {
            $btn.closest('.wpt-search-full-wrapper').find('.query_box_direct_value').val('');
            $btn.closest('.wpt-search-full-wrapper').find('select').val('').change();
            this.state.resetSearchClicked = 'yes';
            $btn.closest('.wpt-search-full-wrapper').find('.wpt-search-products').trigger('click');
        },

        handleCartRemove: function($el) {
            $el.parent('li').fadeOut();
            this.footerCartAnimation();
            $el.addClass('wpt_spin');
            const product_id = $el.data('product_id');
            const cart_item_key = $el.attr('data-cart_item_key');
            const data = {
                action: 'wpt_remove_from_cart',
                product_id,
                cart_item_key,
                nonce: this.config.nonce
            };
            $.ajax({
                type: 'POST',
                url: this.config.ajaxUrl,
                data,
                success: (result) => {
                    $('.wpt-cart-remove.wpt-cart-remove-' + product_id).remove();
                    $('#product_id_' + product_id + ' a.added_to_cart.wc-forward').remove();
                    $(document.body).trigger('wpt_ajax_loaded');
                    $(document.body).trigger('added_to_cart');
                    $(document.body).trigger('updated_cart_totals');
                    $(document.body).trigger('wc_fragments_refreshed');
                    $(document.body).trigger('wc_fragments_refresh');
                    $(document.body).trigger('wc_fragment_refresh');
                    $(document.body).trigger('update_checkout');
                }
            });
        },

        handleEmptyCart: function() {
            this.footerCartAnimation();
            const cart_message_box = $('.wpt-wrap div.tables_cart_message_box');
            cart_message_box.addClass('wpt-ajax-loading');
            $.ajax({
                type: 'POST',
                url: this.config.ajaxUrl,
                data: { action: 'wpt_fragment_empty_cart' },
                complete: function() {
                    cart_message_box.removeClass('wpt-ajax-loading');
                },
                success: function() {
                    $(document.body).trigger('wpt_ajax_loaded');
                    $(document.body).trigger('wc_fragment_refresh');
                    $(document.body).trigger('removed_from_cart');
                },
                error: function() {
                    $(document.body).trigger('wc_fragment_refresh');
                    $(document.body).trigger('wpt_ajax_loaded');
                    console.log('Unable to empty your cart.');
                }
            });
        },

        toggleFooterCart: function() {
            $('body').toggleClass('wpt-footer-cart-expand');
            if ($('body').hasClass('wpt-footer-cart-expand')) {
                $('.wpt-lister').fadeIn('slow');
            } else {
                $('.wpt-lister').fadeOut('slow');
            }
        },

        toggleFooterCartHover: function() {
            $('body').toggleClass('wpt-footer-cart-expand');
            if ($('body').hasClass('wpt-footer-cart-expand')) {
                $('.wpt-lister').fadeIn('medium');
            } else {
                $('.wpt-lister').fadeOut('medium');
            }
        },

        handleInfiniteScroll: function() {
            const infinitScrollButton = $('button.button.wpt_load_more.wpt-load-pagination-infinite_scroll');
            if (infinitScrollButton.length < 1) return;
            const scrollTop = $(window).scrollTop();
            const myTable = $('.wpt-wrap');
            let myTableHeight = myTable.height();
            myTableHeight = myTableHeight - 500;
            if (scrollTop > myTableHeight && this.state.paginatedVal === 0) {
                infinitScrollButton.trigger('click');
                this.state.paginatedVal++;
                setTimeout(() => {
                    this.state.paginatedVal = 0;
                }, 20000);
            }
        },

        ajaxTableLoad: function(table_id, args, others = {}) {
            const thisTable = $('#table_id_' + table_id);
            const TableTagWrap = thisTable.find('.wpt_table_tag_wrapper');
            const SearchWrap = thisTable.find('.wpt-search-full-wrapper');
            const data_json = thisTable.data('basic_settings');
            if (!thisTable.length) {
                console.log('Error on: ajaxTableLoad. Table not found!');
                return;
            }
            others.reset_search_clicked = this.state.resetSearchClicked;
            const data = {
                action: 'wpt_load_both',
                table_id,
                others,
                args,
                atts: data_json.atts,
                nonce: this.config.nonce,
            };
            TableTagWrap.addClass('wpt-ajax-loading');
            SearchWrap.addClass('wpt-ajax-loading');
            $.ajax({
                type: 'POST',
                url: this.config.ajaxUrl,
                data,
                success: (result) => {
                    if (typeof result === 'string') {
                        thisTable.find('table#wpt_table tbody').html(result);
                        return;
                    }
                    if (typeof result !== 'object') return;

                    let page_number = others.page_number || 1;
                    thisTable.attr('data-page_number', page_number);
                    const load_type = others.type;
                    if (result && load_type !== 'load_more') {
                        $.each(result, function(key, value) {
                            if (typeof key === 'string') {
                                let selectedElement = $('#table_id_' + table_id + ' ' + key);
                                if (typeof selectedElement === 'object') {
                                    selectedElement.html(value);
                                }
                            }
                        });
                    } else if (result && load_type === 'load_more') {
                        const thisButton = $('#wpt_load_more_wrapper_' + table_id + '>button');
                        const text_btn = thisButton.data('text_btn');
                        let page_number = thisButton.attr('data-page_number');
                        page_number++;
                        thisButton.attr('data-page_number', page_number);
                        thisButton.html(text_btn);
                        $.each(result, function(key, value) {
                            if (typeof key === 'string') {
                                let selectedElement = $('#table_id_' + table_id + ' ' + key);
                                if (typeof selectedElement === 'object' && key === 'table.wpt-tbl>tbody') {
                                    $('#table_id_' + table_id + ' table.wpt-tbl>tbody').append(value);
                                } else if (typeof selectedElement === 'object') {
                                    selectedElement.html(value);
                                }
                            }
                        });
                    }

                    $(document.body).trigger('wc_fragments_refreshed');
                    $(document.body).trigger('wpt_ajax_loaded');
                    $(document.body).trigger('wpt_ajax_load_data', data);
                    TableTagWrap.removeClass('wpt-ajax-loading');
                    SearchWrap.removeClass('wpt-ajax-loading');
                },
                complete: () => {
                    TableTagWrap.removeClass('wpt-ajax-loading');
                    SearchWrap.removeClass('wpt-ajax-loading');
                    this.state.resetSearchClicked = 'no';
                },
                error: (error) => {
                    TableTagWrap.removeClass('wpt-ajax-loading');
                    SearchWrap.removeClass('wpt-ajax-loading');
                    console.log('Error on: ajaxTableLoad. Error on Ajax load!', error);
                }
            });
        },

        getSearchQueriedArgs: function(table_id) {
            let base_link = $('.wpt-my-pagination-' + table_id).data('base_link');
            let texonomies = {};
            $('#search_box_' + table_id + ' .search_select.query').each(function() {
                const key = $(this).data('key');
                const value = $(this).val();
                if (value !== "") texonomies[key] = value;
            });

            let tax_query = {};
            Object.keys(texonomies).forEach(function(aaa) {
                var key = aaa + '_IN';
                if (texonomies[aaa] !== null && Object.keys(texonomies[aaa]).length > 0) {
                    tax_query[key] = {
                        taxonomy: aaa,
                        field: 'id',
                        terms: texonomies[aaa],
                        operator: 'IN'
                    };
                }
            });

            let custom_field = {}, meta_query = {}, multiple_attr = {};
            $('#search_box_' + table_id + ' .search_select.cf_query').each(function() {
                const attr = $(this).attr('multiple');
                const key = $(this).data('key');
                const value = $(this).val();
                if (value !== "") {
                    custom_field[key] = value;
                    multiple_attr[key] = attr;
                }
            });
            Object.keys(custom_field).forEach(function(key) {
                if (Object.keys(custom_field[key]).length > 0) {
                    var compare = multiple_attr[key];
                    if (!compare) {
                        meta_query[key] = {
                            key: key,
                            value: custom_field[key],
                            compare: 'LIKE'
                        };
                    } else {
                        meta_query[key] = {
                            key: key,
                            value: custom_field[key]
                        };
                    }
                }
            });

            let s = $('#search_box_' + table_id + ' .search_single_direct .query-keyword-input-box').val();
            let orderby = $('#search_box_' + table_id + ' .search_single_order_by select').val();
            let on_sale = $('#search_box_' + table_id + ' .search_single_order select').val();

            return {
                s: s,
                tax_query: tax_query,
                orderby: orderby,
                on_sale: on_sale,
                meta_query: meta_query,
                base_link: base_link,
            };
        },

        fragmentLoad: function() {
            if (this.state.ownFragmentLoad > 0) return;
            setInterval(() => {
                this.state.ownFragmentLoad = 0;
            }, 1000);
            this.state.ownFragmentLoad++;
            $.ajax({
                type: 'POST',
                url: this.config.ajaxUrl,
                data: { action: 'wpt_wc_fragments' },
                success: (ownFragment) => this.wcFragmentHandle(ownFragment)
            });
        },

        wcFragmentHandle: function(ownFragment) {
            if (typeof ownFragment !== 'object') return;
            try {
                this.ownFragmentPerItemsHandle(ownFragment);
                $(document.body).trigger('wpt_fragents_loaded', ownFragment);
            } catch (e) {
                console.log('Something went wrong on ownFragment loads.', ownFragment);
            }
        },

        ownFragmentPerItemsHandle: function(ownFragment) {
            const perItems = ownFragment.per_items || {};
            $('.wpt_row').each(function() {
                const thisRow = $(this);
                const product_id = thisRow.data('product_id');
                if (perItems[product_id] !== undefined) {
                    thisRow.addClass('wpt-added-to-cart');
                    const item = perItems[product_id];
                    const quantity = item.quantity;
                    const cart_item_key = item.cart_item_key;
                    let Bubble = thisRow.find('.wpt_ccount');
                    if (Bubble.length == 0) {
                        thisRow.find('a.add_to_cart_button').append('<span class="wpt_ccount wpt_ccount_' + product_id + '">' + quantity + '</span>');
                        thisRow.find('.single_add_to_cart_button').append('<span class="wpt_ccount wpt_ccount_' + product_id + '">' + quantity + '</span>');
                    } else {
                        Bubble.html(quantity);
                    }
                    let crossButton = thisRow.find('.wpt-cart-remove');
                    if (crossButton.length == 0) {
                        thisRow.find('a.add_to_cart_button').after('<span data-cart_item_key="' + cart_item_key + '" data-product_id="' + product_id + '" class="wpt-cart-remove wpt-cart-remove-' + product_id + '"></span>');
                        thisRow.find('.single_add_to_cart_button').after('<span data-cart_item_key="' + cart_item_key + '" data-product_id="' + product_id + '" class="wpt-cart-remove wpt-cart-remove-' + product_id + '"></span>');
                    }
                } else {
                    thisRow.removeClass('wpt-added-to-cart');
                    thisRow.find('.wpt_ccount').remove();
                    thisRow.find('.wpt-cart-remove').remove();
                }
            });
        },

        footerCartAnimation: function() {
            $('a.wpt-view-n .wpt-bag').addClass('wpt-spin4 animate-spin');
            $('.wpt-new-footer-cart').addClass('wpt-fcart-anim');
            $('.wpt-fcart-coll-expand').addClass('animated');
        },

        deviceWiseResize: function() {
            this.state.currentWidth = $(window).width();
            if (!this.state.isMob && this.state.currentWidth <= 500) {
                this.state.isMob = true;
                this.state.isDesk = false;
                this.genDeskToMobTable();
            }
            if (!this.state.isDesk && this.state.currentWidth > 500) {
                this.state.isMob = false;
                this.state.isDesk = true;
                this.genMobToDeskTable();
            }
        },

        genDeskToMobTable: function() {
            const Table = $('.wpt-auto-responsive .wpt-tbl');
            Table.find('thead').hide();
            const TableBody = Table.find('tbody');
            TableBody.find('tr.wpt-row').each(function() {
                const TableRow = $(this);
                const alreadyGen = TableRow.find('.wpt-replace-td-in-tr').length;
                if (alreadyGen > 0) return;
                let RowData = TableRow.html();
                let reslt = RowData.replaceAll('<td class="td_or_cell', '<div class="td_or_cell');
                reslt = reslt.replaceAll('</td><!--EndTd-->', '</div><!--EndTd-->');
                reslt = "<td class='wpt-replace-td-in-tr'>" + reslt + "</td>";
                TableRow.html(reslt);
            });
        },

        genMobToDeskTable: function() {
            const Table = $('.wpt-auto-responsive .wpt-tbl');
            Table.find('thead').fadeIn();
            const TableBody = Table.find('tbody');
            TableBody.find('tr.wpt-row').each(function() {
                const TableRow = $(this);
                const genreatedData = TableRow.find('td.wpt-replace-td-in-tr');
                if (genreatedData.length < 1) return;
                let RowData = TableRow.find('td.wpt-replace-td-in-tr').html();
                let reslt = RowData.replaceAll('<div class="td_or_cell', '<td class="td_or_cell');
                reslt = reslt.replaceAll('</div><!--EndTd-->', '</td><!--EndTd-->');
                TableRow.html(reslt);
            });
        }
    };

    $(document).ready(function() {
        const config_json = $('#wpt_table').data('config_json');
        if (typeof config_json === 'undefined') return false;
        WPTControl.init();
    });

    window.WPTControl = WPTControl;

})(jQuery);