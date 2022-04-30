<?php 
namespace CA_Framework\Form\Fields;

use CA_Framework\Form\Inc\Field_Base;

/**
 * For Range, I will make a new Type
 * using following 
 * link help.
 * https://nikitahl.com/style-range-input-css
 * 
 * @author Saiful <codersaiful@gmail.com>
 * @link https://nikitahl.com/style-range-input-css
 * 
 * @package CA_Framework
 */
class Input extends Field_Base
{
    private $data_type;
    private $range;
    private $min;
    private $max;
    private $step;

    public function __construct( $args )
    {
        // /data_type
        parent::__construct( $args );
        $this->data_type = $this->args['data_type'] ?? 'text';
        $this->range = $this->args['range'] ?? [];
        $this->min = $this->range['min'] ?? 1;
        $this->max = $this->range['max'] ?? '';
        $this->step = $this->range['step'] ?? '1';
    }
    public function render()
    {

        ?>
        <input 
        <?php if( $this->data_type == 'number' ){ ?>
        min="<?php echo esc_attr( $this->min ); ?>"
        max="<?php echo esc_attr( $this->max ); ?>"
        step="<?php echo esc_attr( $this->step ); ?>"
        <?php } ?>
        type="<?php echo esc_attr( $this->data_type ); ?>"
        value="<?php echo esc_attr( $this->value ); ?>"
        class="ca-field-single <?php echo esc_attr( $this->class_name ); ?>"
        name="<?php echo esc_attr( $this->name ); ?>"
        >
        <?php 
    }

}