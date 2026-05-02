<?php
/**
 * Template Name: صفحة إعادة تعيين كلمة المرور
 * Description: صفحة إعادة تعيين كلمة المرور مخصصة بتصميم متوافق مع القالب.
 */

if (!defined('ABSPATH')) exit;

// إذا كان المستخدم مسجلاً بالفعل، إعادة توجيه للصفحة الرئيسية (يمكن تعديلها)
if (is_user_logged_in()) {
    wp_safe_redirect(home_url('/'));
    exit;
}

get_header();

// التحقق من معلمات إعادة تعيين كلمة المرور
$action = isset($_GET['action']) ? $_GET['action'] : '';
$key = isset($_GET['key']) ? $_GET['key'] : '';
$login = isset($_GET['login']) ? $_GET['login'] : '';

// التحقق مما إذا كانت معلمات إعادة التعيين موجودة
$show_reset_form = ($action === 'rp' || $action === 'resetpass') && !empty($key) && !empty($login);
?>

<main id="primary" class="site-main">
    <section class="min-h-[70vh] py-14 md:py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 max-w-[960px]">
            <div class="text-center mb-10">
                <h1 class="kufi text-2xl md:text-3xl font-black text-secondary mb-2">
                    <?php if ($show_reset_form): ?>
                        إعادة تعيين كلمة المرور
                    <?php else: ?>
                        استعادة كلمة المرور
                    <?php endif; ?>
                </h1>
                <p class="text-gray-500 text-sm">
                    <?php if ($show_reset_form): ?>
                        أدخل كلمة المرور الجديدة لحسابك
                    <?php else: ?>
                        أدخل بريدك الإلكتروني للحصول على رابط استعادة كلمة المرور.
                    <?php endif; ?>
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 items-stretch">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <?php
                    // رسائل الأخطاء/النجاح
                    $errors = array();
                    $success_message = '';

                    if ($show_reset_form) {
                        // عرض نموذج إعادة تعيين كلمة المرور
                        if (isset($_POST['wp_reset_password']) && wp_verify_nonce($_POST['wp_reset_password_nonce'], 'wp_reset_password')) {
                            $password = sanitize_text_field($_POST['password']);
                            $confirm_password = sanitize_text_field($_POST['confirm_password']);

                            // التحقق من كلمة المرور
                            if (empty($password)) {
                                $errors[] = __('الرجاء إدخال كلمة المرور الجديدة.', 'drama-mojaz-theme');
                            } elseif (strlen($password) < 6) {
                                $errors[] = __('كلمة المرور يجب أن تكون مكونة من 6 أحرف على الأقل.', 'drama-mojaz-theme');
                            } elseif ($password !== $confirm_password) {
                                $errors[] = __('كلمتا المرور غير متطابقتين.', 'drama-mojaz-theme');
                            } else {
                                // التحقق من مفتاح إعادة التعيين
                                $user = check_password_reset_key($key, $login);
                                
                                if (!$user || is_wp_error($user)) {
                                    if ($user && $user->get_error_code() === 'expired_key') {
                                        $errors[] = __('انتهت صلاحية رابط إعادة تعيين كلمة المرور.', 'drama-mojaz-theme');
                                    } else {
                                        $errors[] = __('رابط إعادة تعيين كلمة المرور غير صحيح.', 'drama-mojaz-theme');
                                    }
                                } else {
                                    // إعادة تعيين كلمة المرور
                                    $result = reset_password($user, $password);
                                    
                                    if (is_wp_error($result)) {
                                        $errors[] = __('حدث خطأ أثناء إعادة تعيين كلمة المرور.', 'drama-mojaz-theme');
                                    } else {
                                        // تسجيل الدخول تلقائيًا بعد إعادة تعيين كلمة المرور
                                        wp_set_current_user($user->ID);
                                        wp_set_auth_cookie($user->ID);
                                        
                                        $success_message = __('تم إعادة تعيين كلمة المرور بنجاح. جاري توجيهك...', 'drama-mojaz-theme');
                                        
                                        // إعادة توجيه المستخدم
                                        wp_redirect(add_query_arg(array('password_reset' => 'success'), wp_login_url()));
                                        exit;
                                    }
                                }
                            }
                        }
                        ?>

                        <?php if (!empty($errors)): ?>
                            <div class="mb-4 bg-red-50 text-red-700 kufi text-sm px-3 py-2 rounded-lg"><?php echo implode('<br>', array_map('esc_html', $errors)); ?></div>
                        <?php endif; ?>

                        <form class="space-y-4" method="post">
                            <div>
                                <label class="kufi text-xs font-bold text-gray-600 mb-1 block" for="password">كلمة المرور الجديدة</label>
                                <input id="password" type="password" name="password" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm" required autocomplete="new-password">
                            </div>
                            
                            <div>
                                <label class="kufi text-xs font-bold text-gray-600 mb-1 block" for="confirm_password">تأكيد كلمة المرور</label>
                                <input id="confirm_password" type="password" name="confirm_password" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm" required autocomplete="new-password">
                            </div>

                            <input type="hidden" name="wp_reset_password_nonce" value="<?php echo wp_create_nonce('wp_reset_password'); ?>">
                            <input type="hidden" name="key" value="<?php echo esc_attr($key); ?>">
                            <input type="hidden" name="login" value="<?php echo esc_attr($login); ?>">
                            
                            <button type="submit" name="wp_reset_password" class="w-full h-11 md:h-12 bg-primary text-white kufi font-bold rounded-xl hover:bg-primary/90 transition-colors flex items-center justify-center gap-2">
                                <i class="ri-lock-2-line text-lg"></i>
                                <span>إعادة تعيين كلمة المرور</span>
                            </button>
                        </form>

                    <?php } else {
                        // عرض نموذج طلب استعادة كلمة المرور (مثل الصفحة التي أنشأناها مسبقًا)
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

                                        // إرسال البريد الإلكتروني
                                        $sent = wp_mail($user_email, __('Reset your password', 'drama-mojaz-theme'), $message);
                                        
                                        if ($sent) {
                                            $success_message = __('تم إرسال رابط استعادة كلمة المرور إلى بريدك الإلكتروني. يرجى التحقق من بريدك.', 'drama-mojaz-theme');
                                        } else {
                                            $errors[] = __('حدث خطأ أثناء إرسال بريد استعادة كلمة المرور. يرجى المحاولة لاحقاً.', 'drama-mojaz-theme');
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
                    <?php } ?>

                    <div class="text-center mt-4 text-xs text-gray-500">
                        <?php if ($show_reset_form): ?>
                            تذكرت كلمة المرور؟ <a href="<?php echo esc_url(wp_login_url()); ?>" class="text-primary hover:underline">تسجيل الدخول</a>
                        <?php else: ?>
                            تذكرت كلمة المرور؟ <a href="<?php echo esc_url(wp_login_url()); ?>" class="text-primary hover:underline">تسجيل الدخول</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-primary/5 border border-primary/10 rounded-2xl p-6 md:p-8 flex flex-col justify-center">
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-primary text-white flex items-center justify-center shadow-sm mb-4">
                            <?php if ($show_reset_form): ?>
                                <i class="ri-lock-password-line text-2xl"></i>
                            <?php else: ?>
                                <i class="ri-key-2-line text-2xl"></i>
                            <?php endif; ?>
                        </div>
                        <h2 class="kufi font-black text-secondary text-xl mb-3">
                            <?php if ($show_reset_form): ?>
                                أمان كلمة المرور
                            <?php else: ?>
                                استعادة آمنة
                            <?php endif; ?>
                        </h2>
                        <p class="text-gray-600 text-sm leading-7">
                            <?php if ($show_reset_form): ?>
                                استخدم كلمة مرور قوية تتكون من أحرف وأرقام ورموز متنوعة لضمان أمان حسابك.
                            <?php else: ?>
                                سيتم إرسال رابط استعادة كلمة المرور بشكل آمن إلى بريدك الإلكتروني. رابط الاستعادة صالح لفترة محدودة فقط.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
