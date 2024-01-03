<?php
//////////////////////////ФОРМА ГАРАНТИЯ +1ГОД//////////////////////////////
if ( ! function_exists( 'form_stock_garant1' ) ) {
/**
* Display Product Categories
* Hooked into the `homepage` action in the homepage template
*
* @since  1.0.0
* @param array $args the product section args.
* @return void
*/
function form_stock_garant1() {

echo '<div class="gray-box stock-form-background-box">
    <div class="col-full gray-close-box">

        <div class="double-gray-box image-form-box" style="background: url(UR_URL); height: 900px; background-size: 100% 100%; background-position: center; background-repeat: no-repeat;"></div>

        <div class="double-gray-box form-stock-box">
            <div class="form-title">ПРОДЛИМ ГАРАНТИЮ ВАШЕГО ТОВАРА!</div>
            <div class="form-descr">ЗАПОЛНИТЕ ФОРМУ И ПОЛУЧИТЕ +1 ГОД К ГАРАНТИИ</div>
            <div>'.do_shortcode('UR_CONTACT_FORM_7_SHORT_CODE').'</div>
        </div>

    </div>
</div>';

}

}
?>
