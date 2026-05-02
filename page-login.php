<?php
/**
 * Template Name: صفحة تسجيل الدخول
 * Description: صفحة تسجيل دخول مخصصة بتصميم متوافق مع القالب.
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
                <h1 class="kufi text-2xl md:text-3xl font-black text-secondary mb-2">تسجيل الدخول</h1>
                <p class="text-gray-500 text-sm">مرحباً بك مرة أخرى! قم بتسجيل الدخول للمتابعة.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 items-stretch">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <?php
                    // Ensure proper handling of redirect_to parameter
                    $redirect_to = isset($_GET['redirect_to']) ? esc_url_raw($_GET['redirect_to']) : home_url('/');
                    
                    // Additional check for POST redirect_to
                    if (isset($_POST['redirect_to'])) {
                        $redirect_to = esc_url_raw($_POST['redirect_to']);
                    }
                    
                    // Validate redirect_to to ensure it's a local URL
                    if (!empty($redirect_to) && !wp_http_validate_url($redirect_to)) {
                        $redirect_to = home_url('/');
                    }

                    // رسائل الأخطاء/النجاح
                    $errors = array();
                    if (!empty($_GET['login']) && $_GET['login'] === 'failed') {
                        $errors[] = __('بيانات الدخول غير صحيحة، من فضلك حاول مرة أخرى.', 'drama-mojaz-theme');
                    }
                    if (!empty($_GET['loggedout']) && $_GET['loggedout'] === 'true') {
                        echo '<div class="mb-4 bg-green-50 text-green-700 kufi text-sm px-3 py-2 rounded-lg">تم تسجيل الخروج بنجاح.</div>';
                    }

                    if (!empty($errors)) {
                        echo '<div class="mb-4 bg-red-50 text-red-700 kufi text-sm px-3 py-2 rounded-lg">' . implode('<br>', array_map('esc_html', $errors)) . '</div>';
                    }
                    ?>

                    <form class="space-y-4" action="<?php echo esc_url(home_url('/wp-login.php')); ?>" method="post">
                        <div>
                            <label class="kufi text-xs font-bold text-gray-600 mb-1 block" for="user_login">البريد الإلكتروني أو اسم المستخدم</label>
                            <input id="user_login" type="text" name="log" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm" required autocomplete="username">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="kufi text-xs font-bold text-gray-600" for="user_pass">كلمة المرور</label>
                                <a class="kufi text-[11px] text-primary hover:underline" href="<?php echo esc_url(wp_lostpassword_url()); ?>">نسيت كلمة المرور؟</a>
                            </div>
                            <input id="user_pass" type="password" name="pwd" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm" required autocomplete="current-password">
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center gap-2 text-xs text-gray-600">
                                <input type="checkbox" name="rememberme" value="forever" class="rounded text-primary focus:ring-primary">
                                <span class="kufi">تذكرني</span>
                            </label>
                        </div>

                        <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>">
                        <input type="hidden" name="testcookie" value="1">

                        <button type="submit" class="w-full h-11 md:h-12 bg-primary text-white kufi font-bold rounded-xl hover:bg-primary/90 transition-colors flex items-center justify-center gap-2">
                            <i class="ri-login-circle-line text-lg"></i>
                            <span>تسجيل الدخول</span>
                        </button>

                        <?php do_action('login_form'); ?>
                    </form>

                    <div class="text-center mt-4 text-xs text-gray-500">
                        ليس لديك حساب؟ <a href="<?php echo esc_url(wp_registration_url()); ?>" class="text-primary hover:underline">إنشاء حساب جديد</a>
                    </div>
                </div>

                <div class="bg-primary/5 border border-primary/10 rounded-2xl p-6 md:p-8 flex flex-col justify-center">
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-primary text-white flex items-center justify-center shadow-sm mb-4">
                            <i class="ri-shield-user-line text-2xl"></i>
                        </div>
                        <h2 class="kufi font-black text-secondary text-xl mb-3">تصميم أنيق ومتوافق</h2>
                        <p class="text-gray-600 text-sm leading-7">
                            تم تصميم صفحة تسجيل الدخول لتنسجم مع هوية القالب وتعمل بسلاسة على جميع الأجهزة، مع دعم كامل للغة العربية واتجاه RTL.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
