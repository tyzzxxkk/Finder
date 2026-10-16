
<?php
if (!defined('_GNUBOARD_')) exit;

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<section id="bo_w">
    <h2 class="sound_only"><?php echo $g5['title'] ?></h2>

    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
        <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
        <input type="hidden" name="w" value="<?php echo $w ?>">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">

        <?php
        $option = '';
        $option_hidden = '';

        if ($is_notice || $is_html || $is_secret || $is_mail) {
            if ($is_notice) {
                $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="notice" name="notice" class="selec_chk" value="1" '.$notice_checked.'><label for="notice"><span></span>공지</label></li>';
            }

            if ($is_html) {
                if ($is_dhtml_editor) {
                    $option_hidden .= '<input type="hidden" value="html1" name="html">';
                } else {
                    $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="selec_chk" value="'.$html_value.'" '.$html_checked.'><label for="html"><span></span>html</label></li>';
                }
            }

            if ($is_secret) {
                if ($is_admin || $is_secret == 1) {
                    $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="secret" name="secret" class="selec_chk" value="secret" '.$secret_checked.'><label for="secret"><span></span>비밀글</label></li>';
                } else {
                    $option_hidden .= '<input type="hidden" name="secret" value="secret">';
                }
            }

            if ($is_mail) {
                $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="mail" name="mail" class="selec_chk" value="mail" '.$recv_email_checked.'><label for="mail"><span></span>답변메일받기</label></li>';
            }
        }

        echo $option_hidden;
        ?>

        <?php if ($is_category) { ?>
        <div class="bo_w_select write_div">
            <label for="ca_name" class="sound_only">분류</label>
            <select name="ca_name" id="ca_name" required>
                <option value="">분류를 선택하세요</option>
                <?php echo $category_option ?>
            </select>
        </div>
        <?php } ?>

        <div class="bo_w_info write_div">
            <?php if ($is_name) { ?>
            <label for="wr_name" class="sound_only">이름</label>
            <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input half_input required" placeholder="이름">
            <?php } ?>

            <?php if ($is_password) { ?>
            <label for="wr_password" class="sound_only">비밀번호</label>
            <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input half_input <?php echo $password_required ?>" placeholder="비밀번호">
            <?php } ?>

            <?php if ($is_email) { ?>
            <label for="wr_email" class="sound_only">이메일</label>
            <input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input half_input email" placeholder="이메일">
            <?php } ?>

            <?php if ($is_homepage) { ?>
            <label for="wr_homepage" class="sound_only">홈페이지</label>
            <input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="frm_input half_input" placeholder="홈페이지">
            <?php } ?>
        </div>

        <?php if ($option) { ?>
        <div class="write_div">
            <span class="sound_only">옵션</span>
            <ul class="bo_v_option">
                <?php echo $option ?>
            </ul>
        </div>
        <?php } ?>

        <div class="beauty_review_field write_div">
            <label for="wr_2">별점</label>
            <select name="wr_2" id="wr_2" class="frm_input full_input" required>
                <option value="">별점을 선택하세요</option>
                <?php for ($i = 5; $i >= 1; $i--) { ?>
                <option value="<?php echo $i; ?>" <?php echo isset($write['wr_2']) && $write['wr_2'] == $i ? 'selected' : ''; ?>>
                    <?php echo str_repeat('★', $i); ?> (<?php echo $i; ?>점)
                </option>
                <?php } ?>
            </select>
        </div>

        <div class="bo_w_tit write_div">
            <label for="wr_subject" class="sound_only">제목</label>
            <div id="autosave_wrapper" class="write_div">
                <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input full_input required" maxlength="255" placeholder="리뷰 제목">

                <?php if ($is_member) { ?>
                <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
                <?php if ($editor_content_js) echo $editor_content_js; ?>
                <button type="button" id="btn_autosave" class="btn_frmline">임시 저장된 글 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
                <div id="autosave_pop">
                    <strong>임시 저장된 글 목록</strong>
                    <ul></ul>
                    <div><button type="button" class="autosave_close">닫기</button></div>
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="write_div">
            <label for="wr_content" class="sound_only">사용 후기</label>
            <div class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
                <?php if ($write_min || $write_max) { ?>
                <p id="char_count_desc">최소 <?php echo $write_min; ?>글자, 최대 <?php echo $write_max; ?>글자까지 작성할 수 있습니다.</p>
                <?php } ?>

                <?php echo $editor_html; ?>

                <?php if ($write_min || $write_max) { ?>
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </div>
        </div>

        <?php for ($i = 1; $is_link && $i <= G5_LINK_COUNT; $i++) { ?>
        <div class="bo_w_link write_div">
            <label for="wr_link<?php echo $i ?>">링크 <?php echo $i ?></label>
            <input type="text" name="wr_link<?php echo $i ?>" value="<?php if ($w == 'u') echo $write['wr_link'.$i]; ?>" id="wr_link<?php echo $i ?>" class="frm_input full_input">
        </div>
        <?php } ?>

        <?php for ($i = 0; $is_file && $i < $file_count; $i++) { ?>
        <div class="bo_w_flie write_div">
            <div class="file_wr write_div">
                <label for="bf_file_<?php echo $i + 1 ?>">파일 첨부 <?php echo $i + 1 ?></label>
                <input type="file" name="bf_file[]" id="bf_file_<?php echo $i + 1 ?>" class="frm_file">
            </div>

            <?php if ($is_file_content) { ?>
            <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" class="full_input frm_input" placeholder="파일 설명">
            <?php } ?>

            <?php if ($w == 'u' && $file[$i]['file']) { ?>
            <span class="file_del">
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i; ?>]" value="1">
                <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')'; ?> 파일 삭제</label>
            </span>
            <?php } ?>
        </div>
        <?php } ?>

        <?php if ($is_use_captcha) { ?>
        <div class="write_div">
            <?php echo $captcha_html ?>
        </div>
        <?php } ?>

        <div class="btn_confirm write_div">
            <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn_cancel btn">취소</a>
            <button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn">리뷰 등록</button>
        </div>
    </form>

    <script>
    <?php if ($write_min || $write_max) { ?>
    var char_min = parseInt(<?php echo $write_min; ?>);
    var char_max = parseInt(<?php echo $write_max; ?>);
    check_byte("wr_content", "char_count");

    $(function() {
        $("#wr_content").on("keyup", function() {
            check_byte("wr_content", "char_count");
        });
    });
    <?php } ?>

    function html_auto_br(obj) {
        if (obj.checked) {
            var result = confirm("자동 줄바꿈을 사용하시겠습니까?\n\n입력한 줄바꿈을 자동으로 변환합니다.");
            obj.value = result ? "html2" : "html1";
        } else {
            obj.value = "";
        }
    }

    function fwrite_submit(f) {
        <?php echo $editor_js; ?>

        if (!f.wr_2.value) {
            alert("별점을 선택해 주세요.");
            f.wr_2.focus();
            return false;
        }

        var subject = "";
        var content = "";

        $.ajax({
            url: g5_bbs_url + "/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('" + subject + "')가 포함되어 있습니다.");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('" + content + "')가 포함되어 있습니다.");
            if (typeof(ed_wr_content) != "undefined") {
                ed_wr_content.returnFalse();
            } else {
                f.wr_content.focus();
            }
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));

                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 " + char_min + "글자 이상 작성해 주세요.");
                    return false;
                } else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 " + char_max + "글자 이하로 작성해 주세요.");
                    return false;
                }
            }
        }

        <?php echo $captcha_js; ?>

        document.getElementById("btn_submit").disabled = true;

        return true;
    }
    </script>
</section>
