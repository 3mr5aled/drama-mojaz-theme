<?php
/**
 * Template Name: صفحة نسيت كلمة المرور
 * Description: صفحة استعادة كلمة المرور مخصصة بتصميم متوافق مع القالب.
 */

if (!defined('ABSPATH')) exit;

// إذا كان المستخدم مسجلاً بالفعل، إعادة توجيه للصفحة الرئيسية (يمكن تعديلها)
if (is_user_logged_in()) {
    wp_safe_redirect(home_url('/'));
    exit;
}

get_header();
?>

<main id="primary" class="site-main">
    <section class="min-h-[70vh] py-14 md:py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 max-w-[960px]">
            <div class="text-center mb-10">
                <h1 class="kufi text-2xl md:text-3xl font-black text-secondary mb-2">استعادة كلمة المرور</h1>
                <p class="text-gray-500 text-sm">أدخل بريدك الإلكتروني للحصول على رابط استعادة كلمة المرور.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 items-stretch">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <?php
                    // رسائل الأخطاء/النجاح
                    $errors = array();
                    $success_message = '';

                    if (isset($_POST['wp_forgot_password']) && wp_verify_nonce($_POST['wp_forgot_password_nonce'], 'wp_forgot_password')) {
                        $user_login = sanitize_text_field($_POST['user_login']);

                        if (empty($user_login)) {
                            $errors[] = __('الرجاء إدخال اسم المستخدم أو عنوان البريد الإلكتروني.', 'drama-mojaz-theme');
                        } else {
                            // محاولة إيجاد المستخدم
                            if (is_email($user_login)) {
                                $user_data = get_user_by('email', trim($user_login));
                            } else {
                                $user_data = get_user_by('login', trim($user_login));
                            }

                            if (!$user_data) {
                                $errors[] = __('لم يتم العثور على حساب مرتبط بهذا البريد الإلكتروني أو اسم المستخدم.', 'drama-mojaz-theme');
                            } else {
                                // إرسال بريد استعادة كلمة المرور
                                $user_login = $user_data->user_login;
                                $user_email = $user_data->user_email;
                                
                                // إنشاء رابط استعادة كلمة المرور
                                $key = get_password_reset_key($user_data);
                                if (is_wp_error($key)) {
                                    $errors[] = __('حدث خطأ أثناء إنشاء رابط استعادة كلمة المرور.', 'drama-mojaz-theme');
                                } else {
                                    // إعداد البريد الإلكتروني
                                    $message = __(' Someone requested that the password be reset for the following account:', 'drama-mojaz-theme') . "\r\n\r\n";
                                    $message .= network_home_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n\r\n";
                                    $message .= __('If this was a mistake, just ignore this email and nothing will happen.', 'drama-mojaz-theme') . "\r\n\r\n";
                                    $message .= __('To reset your password, visit the following address:', 'drama-mojaz-theme') . "\r\n\r\n";
                                    $message .= network_home_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');

                                    // إرسال البريد الإلكتروني مع محاولة بديلة
                                    $mail_sent = false;
                                    $mail_error = '';
                                    
                                    // محاولة إرسال البريد الإلكتروني
                                    $mail_sent = wp_mail($user_email, __('Reset your password', 'drama-mojaz-theme'), $message);
                                    
                                    // إذا فشل wp_mail، نحاول إرسال بريد بسيط كاختبار
                                    if (!$mail_sent) {
                                        // تهيئة إعدادات PHPMailer
                                        global $phpmailer;
                                        
                                        // إذا كان $phpmailer قد تم تعريفه، نفرغه لمحاولة جديدة
                                        if (!is_object($phpmailer)) {
                                            require_once ABSPATH . WPINC . '/class-phpmailer.php';
                                            require_once ABSPATH . WPINC . '/class-smtp.php';
                                            $phpmailer = new PHPMailer\PHPMailer\PHPMailer(true);
                                        }
                                        
                                        // محاولة إرسال بريد بسيط كاختبار
                                        $test_message = __('Password Reset Request for: ', 'drama-mojaz-theme') . get_bloginfo('name') . "\n\n" . 
                                                       __('Username: ', 'drama-mojaz-theme') . $user_login . '\n' .
                                                       __('If this was a mistake, just ignore this email and nothing will happen.', 'drama-mojaz-theme') . "\n\n" .
                                                       __('Reset URL: ', 'drama-mojaz-theme') . network_home_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
                                        
                                        $mail_sent = wp_mail($user_email, __('Password Reset Request', 'drama-mojaz-theme'), $test_message);
                                    }
                                    
                                    if ($mail_sent) {
                                        $success_message = __('تم إرسال رابط استعادة كلمة المرور إلى بريدك الإلكتروني. يرجى التحقق من بريدك.', 'drama-mojaz-theme');
                                    } else {
                                        // في حالة الفشل، نعرض رسالة توضيحية
                                        $errors[] = __('حدث خطأ أثناء إرسال بريد استعادة كلمة المرور. قد يكون هناك مشكلة في إعدادات خادم البريد.', 'drama-mojaz-theme');
                                        $errors[] = __('الرجاء الاتصال بمسؤول الموقع أو محاولة تسجيل الدخول باستخدام وسائل أخرى.', 'drama-mojaz-theme');
                                        
                                        // تسجيل الخطأ في سجلات WordPress للمساعدة في التصحيح
                                        error_log('Password reset email failed for user: ' . $user_login . ' with email: ' . $user_email);
                                    }
                                }
                            }
                        }
                    }
                    ?>

                    <?php if (!empty($errors)): ?>
                        <div class="mb-4 bg-red-50 text-red-700 kufi text-sm px-3 py-2 rounded-lg"><?php echo implode('<br>', array_map('esc_html', $errors)); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($success_message)): ?>
                        <div class="mb-4 bg-green-50 text-green-700 kufi text-sm px-3 py-2 rounded-lg"><?php echo esc_html($success_message); ?></div>
                    <?php endif; ?>

                    <form class="space-y-4" method="post">
                        <div>
                            <label class="kufi text-xs font-bold text-gray-600 mb-1 block" for="user_login">البريد الإلكتروني أو اسم المستخدم</label>
                            <input id="user_login" type="text" name="user_login" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm" required autocomplete="username" value="<?php echo isset($_POST['user_login']) ? esc_attr($_POST['user_login']) : ''; ?>">
                        </div>

                        <input type="hidden" name="wp_forgot_password_nonce" value="<?php echo wp_create_nonce('wp_forgot_password'); ?>">
                        
                        <button type="submit" name="wp_forgot_password" class="w-full h-11 md:h-12 bg-primary text-white kufi font-bold rounded-xl hover:bg-primary/90 transition-colors flex items-center justify-center gap-2">
                            <i class="ri-lock-unlock-line text-lg"></i>
                            <span>استعادة كلمة المرور</span>
                        </button>
                    </form>

                    <div class="text-center mt-4 text-xs text-gray-500">
                        تذكرت كلمة المرور؟ <a href="<?php echo esc_url(wp_login_url()); ?>" class="text-primary hover:underline">تسجيل الدخول</a>
                    </div>
                </div>

                <div class="bg-primary/5 border border-primary/10 rounded-2xl p-6 md:p-8 flex flex-col justify-center">
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-primary text-white flex items-center justify-center shadow-sm mb-4">
                            <i class="ri-key-2-line text-2xl"></i>
                        </div>
                        <h2 class="kufi font-black text-secondary text-xl mb-3">استعادة آمنة</h2>
                        <p class="text-gray-600 text-sm leading-7">
                            سيتم إرسال رابط استعادة كلمة المرور بشكل آمن إلى بريدك الإلكتروني. رابط الاستعادة صالح لفترة محدودة فقط.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
