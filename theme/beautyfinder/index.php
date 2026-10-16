<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit;

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if (G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<div class="beauty-main">

    <section class="beauty-hero">
        <p class="hero-label">YOUR BEAUTY, YOUR STYLE</p>
        <h2>나에게 맞는 뷰티를 찾아보세요.</h2>
        <p>솔직한 후기부터 새로운 제품 추천까지,<br>
        뷰티에 관한 이야기를 나누는 공간</p>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=beauty_review"
           class="beauty-button">리뷰 보러 가기</a>
    </section>

    <section class="beauty-section">
        <div class="section-heading">
            <div>
                <p class="section-label">BEAUTY REVIEW</p>
                <h2>최신 뷰티 리뷰</h2>
            </div>
            <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=beauty_review">
                리뷰 더보기 →
            </a>
        </div>

        <?php
        echo latest('theme/basic', 'beauty_review', 4, 30);
        ?>
    </section>

    <section class="beauty-guide">
        <p class="section-label">FIND YOUR BEAUTY</p>
        <h2>오늘은 어떤 제품이 궁금하세요?</h2>
        <p>사용해 본 제품의 경험을 나누고<br>
        다른 사람들의 리뷰도 확인해 보세요.</p>
        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=beauty_review"
           class="beauty-button">뷰티 리뷰 둘러보기</a>
    </section>

</div>

<?php
include_once(G5_THEME_PATH.'/tail.php');