[{include file=$oViewConf->getModulePath("vt-devutils","views/admin/vt_devutils__header.tpl")}]
<div style="padding: 25px;">

        <div id="codeinput" style="min-height: 300px; border: 1px solid #cfcfcf;">[{$codeinput|default:""}]</div>
        <script type="text/javascript" src="//cdn.jsdelivr.net/ace/1.1.3/min/ace.js"></script>
        <script type="text/javascript">
            var f = top.basefrm.document;
            var editor = ace.edit("codeinput");
            editor.setTheme("ace/theme/github");
            editor.getSession().setMode({path:"ace/mode/php", inline:true});

            var eval = function() {
                f.getElementById("target").value = editor.getValue();
                f.getElementById("console").submit();
            }
        </script>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <form name="vtdu_console" id="console" class="form-horizontal" action="[{ $oViewConf->getSelfLink() }]" method="post">
                <input type="hidden" name="cl" value="[{$oView->getClassName()}]"/>
                <input type="hidden" name="fnc" value="doTest"/>
                <input type="hidden" name="codeinput" value="" id="target"/>
            </form>
            <button type="submit" class="button expand" onclick="Javascript:eval();">EVALUATE</button>
        </div>
        <div class="small-12 medium-6 columns text-center">
            <strong style="line-height: 20px; color: red"><br/>all the php code will be evaluated!<br/>bad code may brake your shop or server!</strong>
        </div>
    </div>

        [{if $codeerror}]
            <pre>[{$codeerror|var_dump}]</pre>
        [{else}]
            <textarea class="form-control" style="min-height: [{if $codeoutput}]3[{else}]2[{/if}]00px;">[{$codeoutput|default:""}]</textarea>
        [{/if}]

</div>

[{include file=$oViewConf->getModulePath("vt-devutils","views/admin/vt_devutils__footer.tpl")}]