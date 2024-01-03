<?php
/////////////////////////////ГАРАНТИЯ///////////////////////////////////////////

add_filter('wpcf7_form_elements', function ($content) {
    if (strpos($content, 'dynamic_select id:select_item') !== false) {
        ob_start();
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var select = document.querySelector('select#select_item');
                if (select) {
                    <?php
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                    );
                    $products = get_posts($args);

                    foreach ($products as $product) {
                        echo 'select.options.add(new Option("' . esc_html($product->post_title) . '", ' . esc_attr($product->ID) . '));';
                    }
                    ?>
                }
            });
        </script>
        <?php
        ob_end_flush();
        $content = str_replace('dynamic_select id:select_item', '', $content);
    }
    return $content;
});



add_action('wpcf7_before_send_mail', 'custom_process_form_data_garant');

function custom_process_form_data_garant($contact_form) {
    $form = WPCF7_ContactForm::get_current();

    $order_number = sanitize_text_field($_POST['text-555']);
    $email = sanitize_email($_POST['email-176']);
    $date = sanitize_text_field($_POST['date-517']);
    $product_id = sanitize_text_field($_POST['menu-302']);
    $product_name = get_the_title($product_id);
    $date_obj = $date ? DateTime::createFromFormat('Y-m-d', $date) : null;
    $new_date = $date_obj ? $date_obj->modify('+1 years')->format('Y-m-d') : '';


  
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );
    $products = get_posts($args);

    $product_options = array();

    foreach ($products as $product) {
        $product_options[$product->ID] = $product->post_title;
    }

        $message = '<html lang = "ru">
<body>
<div style="max-width: 800px; margin: 20px auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

    <div style="text-align: center;">
        <img src="UR_URL" alt="logomail" style="max-width: 100%;">
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <p style="color: #333; font-size: 32px; font-weight: 600; margin: 0;">Здравствуйте!</p>
        <p style="color: #333; font-size: 32px; font-weight: 600; margin: 0;">Дорогой клиент</p>
        <p style="color: #333; font-size: 18px; margin: 10px 0;">Ваш номер заказа '. $order_number .'</p>
        <p style="color: #333; font-size: 18px; margin: 10px 0;">Ваш товар: <span style="color: #333; font-weight: 600;">' . $product_name . '</span></p>
    </div>

    <div style="text-align: center; margin-top: 40px; padding: 20px; background: rgba(248, 248, 248, 0.71); border-radius: 10px;">
        <div style="margin-bottom: 20px;">
            <img src="UR_URL" alt="garant-1-e1703070795314" style="max-width: 100%;">
        </div>
        <p style="color: #333; font-size: 28px; font-weight: 600; margin: 0;">Ваша гарантия</p>
        <p style="color: #333; font-size: 18px; margin: 10px 0;">Успешно продлена до</p>
        <p style="color: #f5c76d; font-size: 21px; font-weight: 600; margin: 0 auto; border-radius: 1000px; background: #FFF; width: 203px; height: 40px; line-height: 40px; text-align: center;">'. $new_date .'</p>
        <a href="UR_URL" style="text-decoration: none;">
        <div style="background: linear-gradient(90deg, #f1d9a9 0%, #f8edda 100%); border-radius: 6px; display: inline-flex; justify-content: center; align-items: center; gap: 10px; padding: 10px 40px; width: 200px; height: 20px; margin: 20px auto;">
            <p style="color: #000; font-size: 18px; font-weight: 400; margin: 0;">Перейти к покупкам</p>
        </div>
        </a>
    </div>

</div>
</body>
</html>';

        $utm_source = sanitize_text_field($_POST['utm_source']);
        $utm_medium = sanitize_text_field($_POST['utm_medium']);
        $utm_term = sanitize_text_field($_POST['utm_term']);
        $utm_content = sanitize_text_field($_POST['utm_content']);

        $_POST['utm_source'] = $utm_source;
        $_POST['utm_medium'] = $utm_medium;
        $_POST['utm_term'] = $utm_term;
        $_POST['utm_content'] = $utm_content;

        $mail_to = $email;
        $mail_subject = 'ГАРАНТИЯ +1 ГОД';
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            "From: Stoewer <UR_MAIL>"
        );

        wp_mail($mail_to, $mail_subject, $message, $headers);
}
?>
