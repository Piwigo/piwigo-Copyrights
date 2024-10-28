<div class = "titlePage">
  <h2>{'Copyrights'|@translate}</h2>
</div>

<!-- Create the form for creating and editing copyrights -->
<form action='{$COPYRIGHTS_PATH}-{if $edit == 0}create{else}update{/if}'
      method='POST'>
  <fieldset>
    <legend>{if $edit == 0}{'Create copyright'|@translate}
            {else}{'Update copyright'|@translate}{/if}</legend>
      <!-- If $edit != 0 we should remember the id of the copyright that is
           edited -->
      {if $edit != 0}<input type='hidden' name='id' id='id' value='{$CRid}' />{/if}
      <!-- Put all the attributes of the copyright in a nice table -->
      <table>
        <tr>
          <td>{'Name'|@translate}</td>
          <td><input type='text' name='name' id='name' value='{$CRname|escape}' /></td>
        </tr>
        <tr>
          <td>{'URL'|@translate}</td>
          <td><input type='text' name='url'  id='url'  value='{$CRurl|escape}' /></td>
        </tr>
        <tr>
          <td>{'Description'|@translate}</td>
          <td><textarea name='descr' id='descr'>{$CRdescr}</textarea></td>
        </tr>
        <tr>
          <td>{'Visible'|@translate}</td>
          <td>{if $CRvisible != 0}
            <input type='checkbox' name='visible' id='visible' value='show' checked='checked' />
          {else}
            <input type='checkbox' name='visible' id='visible' value='show' />
            {/if}</td>
        </tr>
        <tr>
          <td></td>
          <td><input type='submit' value="{if $edit == 0}{'Create'|@translate}{else}{'Update'|@translate}{/if}" /></td>
        </tr>
      </table>
  </fieldset>
</form>

<!-- If we are on the 'homepage', show a table of all copyrights -->
{if $edit == 0}
<form>
  <fieldset>
    <legend>{'Edit copyright'|@translate}</legend>
    <table>
      <tr>
        <!-- Create a nice header row -->
        <th>{'Name'|@translate}</th>
        <th>{'URL'|@translate}</th>
        <th>{'Description'|@translate}</th>
        <th>{'Visible'|@translate}</th>
        <th>{'Actions'|@translate}</th>
      </tr>
    <!-- Loop over all copyrights -->
    {if not empty($CRs)}
    {foreach from=$CRs item=CR}
    {strip}
      <tr class="{cycle values="row1,row2"}"> <!-- This gives nicely colored
                                                   table rows -->
        <td>{$CR.name}</td>
        <td><a href="{$CR.url}">{$CR.url}</a></td>
        <td>{$CR.descr}</td>
        <td>{if $CR.visible != 0}{'Yes'|@translate}
          {else}{'No'|@translate}{/if}
        </td>
        <!-- Show nice Edit and Delete icons -->
        <td>
          <a href="{$COPYRIGHTS_PATH}-edit&id={$CR.cr_id}">
            <img src="{$ROOT_URL}{$themeconf.admin_icon_dir}/edit_s.png"
            alt="{'Edit'|@translate}" title="{'Edit'|@translate}" />
          </a>
          <a href="{$COPYRIGHTS_PATH}-delete&id={$CR.cr_id}" onclick="return confirm(document.getElementById('btn_delete').title + '\n\n' + '{'Are you sure?'|@translate|@escape:'javascript'}');">
            <img src="{$ROOT_URL}{$themeconf.admin_icon_dir}/delete.png"
            id="btn_delete" alt="{'Delete'|@translate}" title="{'Delete copyright'|@translate}" />
          </a>
        </td>
      </tr>
    {/strip}
    {/foreach}
    {/if}
    </table>
  </fieldset>
</form>
{/if}
