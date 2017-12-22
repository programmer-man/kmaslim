<?php
/*
 * Template for KMA SEO meta boxes
 */
?>
<div class="seo-meta-box-content">
    <table width="100%" cellpadding="5px">
        <tr>
            <td width="15%" align="right" valign="top">
                <label for="kma_seo_title">SEO Title</label>
            </td>
            <td>
                <input type="text" name="custom_meta[kma_seo_title]" id="kma_seo_title" value="<?= $seoTitle; ?>" style="width: 100%" class="form-control" />
            </td>
            <td width="150">
                <span class="kma_seo_title_left">70</span> characters left
            </td>
        </tr>
        <tr>
            <td width="15%" align="right" valign="top">
                <label for="kma_meta_description">Meta Description</label>
            </td>
            <td>
                <textarea type="text" name="custom_meta[kma_meta_description]" id="kma_meta_description" style="width: 100%" class="form-control" ><?= $metaDescription; ?></textarea>
            </td>
            <td width="150">
                <span class="kma_meta_description_left">160</span> characters left
            </td>
        </tr>
        <tr>
            <td width="15%" align="right" valign="top" style="padding-top:20px;">
                <label for="snippet_preview">Search Preview</label>
            </td>
            <td colspan="2" style="padding: 20px;">
                <div class="snippet-container">
                    <p class="kma-seo-title"><?= $seoTitle; ?></p>
                    <p class="kma-permalink"><?= $permalink; ?></p>
                    <p class="kma-meta-desc"><?= $metaDescription; ?></p>
                </div>
            </td>
        </tr>
        <tr>
            <td width="15%" align="right" valign="top">
                <label for="kma_seo_title">Allow Indexing</label>
            </td>
            <td colspan="2">
                <input type="radio" name="custom_meta[kma_allow_indexing]" id="kma_allow_indexing_yes" value="<?= $allowIndexing == 'yes' || $allowIndexing == '' ? 'selected' : ''; ?>" class="form-control index-radio" /><label>yes</label> &nbsp;
                <input type="radio" name="custom_meta[kma_allow_indexing]" id="kma_allow_indexing_no" value="<?= $allowIndexing == 'no' ? 'selected' : ''; ?>" class="form-control index-radio" /><label>no</label>
            </td>
        </tr>
    </table>
</div>

<style>
    .kma-seo-title {
        font-size: 18px;
        color: #1a0dab;
        cursor: pointer;
        text-decoration: none;
        font-weight: normal;
        font-family: arial,sans-serif;
        margin:0; padding:0;
    }
    .kma-permalink {
        font-size: 14px;
        line-height: 16px;
        color: #006621;
        font-style: normal;
        cursor: pointer;
        text-decoration: none;
        font-weight: normal;
        font-family: arial,sans-serif;
        margin:0; padding:0;
    }
    .kma-meta-desc {
        word-wrap: break-word;
        color: #545454;
        font-size: 14px;
        line-height: 16px;
        margin:2px 0; padding:0;
    }
    .index-radio {
        margin-bottom: -7px !important;
    }
    @media screen and (min-width: 1024px) {
        .snippet-container {
            width: 600px;
            max-width: 100%;
        }
    }
    .error {
        color: red;
    }
</style>
<script>
    jQuery(document).ready(function($){
        let titleTextInput = $('#kma_seo_title'),
            titleTextLeft  = $('.kma_seo_title_left'),
            metaDescInput  = $('#kma_meta_description'),
            metaDescLeft   = $('.kma_meta_description_left');

        function updateCounts(input, count, view){
            var newNum = parseInt(count) - parseInt(input.length)

            if(newNum < 0){
                newNum = 0
                view.addClass('error');
            }
            console.log( newNum );

            return newNum;
        }

        titleTextLeft.text(updateCounts(titleTextInput.val(), 70, titleTextLeft));
        metaDescLeft.text(updateCounts(metaDescInput.val(), 160, metaDescLeft));

        titleTextInput.on('input', function() {
            titleTextLeft.text(updateCounts(titleTextInput.val(), 70, titleTextLeft));
            $('.kma-seo-title').text(titleTextInput.val());
        });
        metaDescInput.on('input', function() {
            metaDescLeft.text(updateCounts(metaDescInput.val(), 160, metaDescLeft));
            $('.kma-meta-desc').text(metaDescInput.val());
        });

    });


</script>
