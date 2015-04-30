[not-group=5]
<div class="login-a">
<a href="{profile-link}">{login}</a>
[admin-link]<a href="{admin-link}" target="_blank"><b>Админка</b></a>[/admin-link]
<a href="{favorites-link}">Закладки ({favorite-count})</a>
<a href="{pm-link}">Сообщения: ({new-pm} | {all-pm})</a>
<a href="{addnews-link}">Добавить фильм</a>
<a href="http://rufilms.org/index.php?do=lastcomments">Комментарии</a>
<a class="thide lexit" href="{logout-link}"><i>Выход</i></a>
</div>

[/not-group]
[group=5]
<div class="login-a">
<form method="post" action="">
{login-method}<input type="text" name="login_name" id="login_name" />&nbsp;Пароль:<input type="password" name="login_password" id="login_password" />
<button class="fbutton" onclick="submit();" type="submit" title="Войти"><span>Войти</span></button>
<a href="{lostpassword-link}">Забыли пароль?</a><a href="{registration-link}">Регистрация</a>
<input name="login" type="hidden" id="login" value="submit" />
</form>
</div>
[/group]