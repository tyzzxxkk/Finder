
<?php
if (!defined('_GNUBOARD_')) exit;

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if (G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');

add_stylesheet(
    '<link rel="stylesheet" href="'.G5_THEME_URL.'/css/beauty.css">',
    10
);

include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title']; ?></h1>

    <div id="skip_to_container">
        <a href="#container">본문 바로가기</a>
    </div>

    <?php
    if (defined('_INDEX_')) {
        include G5_BBS_PATH.'/newwin.inc.php';
    }
    ?>

    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL; ?>/">
                BEAUTY FINDER
            </a>
        </div>

        <div class="hd_sch_wr">
            <fieldset id="hd_sch">
                <legend>사이트 내 전체검색</legend>

                <form name="fsearchbox"
                      method="get"
                      action="<?php echo G5_BBS_URL; ?>/search.php"
                      onsubmit="return fsearchbox_submit(this);">

                    <input type="hidden" name="sfl"
                           value="wr_subject||wr_content">
                    <input type="hidden" name="sop" value="and">

                    <label for="sch_stx" class="sound_only">
                        검색어 필수
                    </label>

                    <input type="text"
                           name="stx"
                           id="sch_stx"
                           maxlength="20"
                           value="<?php echo isset($_GET['stx']) ? get_text($_GET['stx']) : ''; ?>"
                           placeholder="어떤 뷰티 제품이 궁금하세요?">

                    <button type="submit" id="sch_submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <span class="sound_only">검색</span>
                    </button>
                </form>

                <script>
                function fsearchbox_submit(f) {
                    var stx = f.stx.value.trim();

                    if (stx.length < 2) {
                        alert("검색어는 두 글자 이상 입력해 주세요.");
                        f.stx.focus();
                        return false;
                    }

                    var cnt = 0;

                    for (var i = 0; i < stx.length; i++) {
                        if (stx.charAt(i) == ' ') cnt++;
                    }

                    if (cnt > 1) {
                        alert("검색어에는 공백을 한 개만 사용할 수 있습니다.");
                        f.stx.focus();
                        return false;
                    }

                    f.stx.value = stx;
                    return true;
                }
                </script>
            </fieldset>
        </div>

        <ul class="hd_login">
            <?php if ($is_member) { ?>
                <li>
                    <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=<?php echo G5_BBS_URL; ?>/register_form.php">
                        정보수정
                    </a>
                </li>
                <li>
                    <a href="<?php echo G5_BBS_URL; ?>/logout.php">
                        로그아웃
                    </a>
                </li>

                <?php if ($is_admin) { ?>
                    <li class="tnb_admin">
                        <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">
                            관리자
                        </a>
                    </li>
                <?php } ?>

            <?php } else { ?>
                <li>
                    <a href="<?php echo G5_BBS_URL; ?>/register.php">
                        회원가입
                    </a>
                </li>
                <li>
                    <a href="<?php echo G5_BBS_URL; ?>/login.php">
                        로그인
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <nav id="gnb">
        <h2>메인메뉴</h2>

        <div class="gnb_wrap">
            <ul id="gnb_1dul">

                <?php
                $menu_datas = get_menu_db(0, true);
                $gnb_zindex = 999;
                $i = 0;

                foreach ($menu_datas as $row) {
                    if (empty($row)) continue;

                    $add_class = (
                        isset($row['sub']) && $row['sub']
                    ) ? 'gnb_al_li_plus' : '';
                ?>

                    <li class="gnb_1dli <?php echo $add_class; ?>"
                        style="z-index:<?php echo $gnb_zindex--; ?>">

                        <a href="<?php echo $row['me_link']; ?>"
                           target="_<?php echo $row['me_target']; ?>"
                           class="gnb_1da">
                            <?php echo get_text($row['me_name']); ?>
                        </a>

                        <?php
                        $k = 0;

                        foreach ((array) $row['sub'] as $row2) {
                            if (empty($row2)) continue;

                            if ($k == 0) {
                                echo '<div class="gnb_2dul"><ul class="gnb_2dul_box">';
                            }
                        ?>

                            <li class="gnb_2dli">
                                <a href="<?php echo $row2['me_link']; ?>"
                                   target="_<?php echo $row2['me_target']; ?>"
                                   class="gnb_2da">
                                    <?php echo get_text($row2['me_name']); ?>
                                </a>
                            </li>

                        <?php
                            $k++;
                        }

                        if ($k > 0) {
                            echo '</ul></div>';
                        }
                        ?>
                    </li>

                <?php
                    $i++;
                }

                if ($i == 0) {
                ?>
                    <li class="gnb_1dli">
                        <a href="<?php echo G5_URL; ?>/" class="gnb_1da">
                            홈
                        </a>
                    </li>

                    <li class="gnb_1dli">
                        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=beauty_review"
                           class="gnb_1da">
                            뷰티 리뷰
                        </a>
                    </li>
                <?php } ?>

            </ul>

            <div id="gnb_all">
                <h2>전체메뉴</h2>
                <ul class="gnb_al_ul">

                    <?php foreach ($menu_datas as $row) {
                        if (empty($row)) continue;
                    ?>

                        <li class="gnb_al_li">
                            <a href="<?php echo $row['me_link']; ?>"
                               class="gnb_al_a">
                                <?php echo get_text($row['me_name']); ?>
                            </a>

                            <?php if (!empty($row['sub'])) { ?>
                                <ul>
                                    <?php foreach ($row['sub'] as $row2) {
                                        if (empty($row2)) continue;
                                    ?>
                                        <li>
                                            <a href="<?php echo $row2['me_link']; ?>">
                                                <?php echo get_text($row2['me_name']); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>

                    <?php } ?>

                </ul>

                <button type="button" class="gnb_close_btn">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <div id="gnb_all_bg"></div>
        </div>
    </nav>

    <script>
    $(function () {
        $(".gnb_menu_btn").click(function () {
            $("#gnb_all, #gnb_all_bg").show();
        });

        $(".gnb_close_btn, #gnb_all_bg").click(function () {
            $("#gnb_all, #gnb_all_bg").hide();
        });
    });
    </script>
</div>

<hr>

<div id="wrapper">
    <div id="container_wr">
        <div id="container">
            <?php
            if (!defined('_INDEX_')) {
            ?>
                <h2 id="container_title">
                    <span title="<?php echo get_text($g5['title']); ?>">
                        <?php echo get_head_title($g5['title']); ?>
                    </span>
                </h2>
            <?php } ?>
