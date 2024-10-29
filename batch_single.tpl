{combine_script id="jquery.copyrights" load="footer" path="{$COPYRIGHTS_PATH}/js/bm_unit_copyrights.js"}
{$selected_element_copyrights = (isset($CRcopyrights[$element.ID])) ? $CRcopyrights[$element.ID] : ""}
<div class="half-line-info-box batch_single_copyrights">
  <div>
    <strong>{'Copyright'|@translate}</strong>
  </div>
  <select class="batch_single_copyrights_select" id="copyright-{$element.ID}" name="copyright-{$element.ID}">
    <option value="">--</option>
{html_options options=$CRoptions selected=$selected_element_copyrights}
  </select>
</div>

{html_style}
  .batch_single_copyrights {
    flex: 0 0 calc(100% - 20px);
  }
{/html_style}