<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$path = sprintf('%s%s', getenv('DOCUMENT_ROOT'), $templateFolder);
if (file_exists($path . '/user_type.php')) {
    include $path . '/user_type.php';
}

if ($arParams['AJAX'] == 'Y') {
    $APPLICATION->AddHeadScript($templateFolder . '/script.js');
}

$APPLICATION->SetAdditionalCSS($templateFolder . '/style.css');
?>

<? if ($arResult['SUCCESS'] === true): ?>
    <?= GetMessage('SUCCESS_MESSAGE') ?>
<? endif; ?>

<? foreach ($arResult['ERRORS'] as $nameFiled => $value): ?>
    <?= $value ?>
<? endforeach; ?>

<form action="<?= POST_FORM_ACTION_URI ?>" method="post" enctype="multipart/form-data"
      id="form-feedback-<?= $arResult['FORM']['COMPONENT_ID'] ?>">
    <? $userTypePrint($arResult); ?>
    <? if ($arParams['USE_CAPTCHA'] == 'Y'): ?>
        <img class="captcha-image" src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult['CAPTCHA_CODE'] ?>"
             alt="CAPTCHA" width="110" height="33"/>
        <a href="#" class="captcha-reload"><?= GetMessage('CAPTCHA_RELOAD') ?></a>
        <input type="hidden" name="captcha_sid" value="<?= $arResult['CAPTCHA_CODE'] ?>"/>
        <input type="text" name="captcha_word" value="<?= $arResult['FORM']['CAPTCHA'] ?>"/>
    <? endif; ?>
    <? if ($arParams['AJAX'] == 'Y'): ?>
        <input type="hidden" name="ajax_id" value="<?= $arResult['FORM']['COMPONENT_ID'] ?>"/>
    <? endif; ?>
    <input type="submit" class="submit-form" name="send_form_<?= $arResult['FORM']['COMPONENT_ID'] ?>"
           value="<?= GetMessage('FILED_SUBMIT') ?>"/>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        var
            feedback = new Feedback('#form-feedback-<?=$arResult['FORM']['COMPONENT_ID']?>'),
            feedbackForm = $('#form-feedback-<?=$arResult['FORM']['COMPONENT_ID']?>');

        feedbackForm.on('click', '.captcha-reload', function () {
            feedback.reloadCaptcha();
            return false;
        });

        <?if($arParams['AJAX'] == 'Y'):?>
        feedbackForm.submit(function () {
            feedback.submitForm(function (response) {
                console.log(response);
            });
            return false;
        });
        <?endif;?>
    });
</script>