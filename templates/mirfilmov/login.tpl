[not-group=5]
<div class="login-a">
<a href="{profile-link}">{login}</a>
[admin-link]<a href="{admin-link}" target="_blank"><b>�������</b></a>[/admin-link]
<a href="{favorites-link}">�������� ({favorite-count})</a>
<a href="{pm-link}">���������: ({new-pm} | {all-pm})</a>
<a href="{addnews-link}">�������� �����</a>
<a href="http://rufilms.org/index.php?do=lastcomments">�����������</a>
<a class="thide lexit" href="{logout-link}"><i>�����</i></a>
</div>

[/not-group]
[group=5]
<div class="login-a">
<form method="post" action="">
{login-method}<input type="text" name="login_name" id="login_name" />&nbsp;������:<input type="password" name="login_password" id="login_password" />
<button class="fbutton" onclick="submit();" type="submit" title="�����"><span>�����</span></button>
<a href="{lostpassword-link}">������ ������?</a><a href="{registration-link}">�����������</a>
<input name="login" type="hidden" id="login" value="submit" />
</form>
</div>
[/group]