[pmlist]
<div class="sortn"><h3>Список сообщений</h3></div>
[/pmlist]
[newpm]
<div class="sortn"><h3>Новое сообщение</h3></div>
[/newpm]
[readpm]
<div class="sortn"><h3>Ваши сообщения</h3></div>
[/readpm]
<div class="opr">
<div class="dpad">
<div class="pm_status">
	<div class="pm_status_head">Состояние папок</div>
	<div class="pm_status_content">Папки персональных сообщений заполнены на:
{pm-progress-bar}
{proc-pm-limit}% от лимита ({pm-limit} сообщений)
	</div>
</div>
<div style="padding-top:10px;">[inbox]Входящие сообщения[/inbox]<br /><br />
[outbox]Отправленные сообщения[/outbox]<br /><br />
[new_pm]Отправить сообщение[/new_pm]</div>
</div><br />
<div class="clr"></div>
<br />
[pmlist]
<div class="dpad">{pmlist}</div>
[/pmlist]
[newpm]
<div class="baseform">
	<table class="tableform">
		<tr>
			<td class="label">
				Кому:
			</td>
			<td><input type="text" name="name" value="{author}" class="f_input" /></td>
		</tr>
		<tr>
			<td class="label">
				Тема:<span class="impot">*</span>
			</td>
			<td><input type="text" name="subj" value="{subj}" class="f_input" /></td>
		</tr>
		<tr>
			<td class="label">
				Сообщение:<span class="impot">*</span>
			</td>
			<td class="editorcomm">
			{editor}<br />
			<div class="checkbox"><input type="checkbox" id="outboxcopy" name="outboxcopy" value="1" /> <label for="outboxcopy">Сохранить сообщение в папке "Отправленные"</label></div>
			</td>
		</tr>
		[sec_code]
		<tr>
			<td class="label">
				Код:<span class="impot">*</span>
			</td>
			<td>
				<div>{sec_code}</div>
				<div><input type="text" name="sec_code" id="sec_code" style="width:115px" class="f_input" /></div>
			</td>
		</tr>
		[/sec_code]
		[recaptcha]
		<tr>
			<td class="label">
				Введите два слова, показанных на изображении:<span class="impot">*</span>
			</td>
			<td>
				<div>{recaptcha}</div>
			</td>
		</tr>
		[/recaptcha]
		[question]
			<tr>
				<td class="label">
					Вопрос:
				</td>
				<td>
					<div>{question}</div>
				</td>
			</tr>
			<tr>
				<td class="label">
					Ответ:<span class="impot">*</span>
				</td>
				<td>
					<div><input type="text" name="question_answer" id="question_answer" class="f_input" /></div>
				</td>
			</tr>
		[/question]
	</table>
	<div class="fieldsubmit">
		<button type="submit" name="add" class="fbutton voteb"><span>Отправить</span></button>
		<input type="button" class="fbutton voteb" onclick="dlePMPreview()" title="Просмотр" value="Просмотр" />
	</div>	
</div>
[/newpm]
[readpm]
<div class="bcomment">
	<div class="dtop">
		<img src="{foto}" alt=""/>
	</div>
	<div class="reset-b">
			<ul class="resett">
				<li>{author}</li>
				<li>{group-name}</li>
				<li>{date}</li>
			</ul>
			<ul class="reset-r">
				<li>[complaint]Пожаловаться[/complaint]</li>
				<li>[ignore]Игнорировать[/ignore]</li>
				<li>[del]Удалить[/del]</li>
			</ul>
	</div>
		<h3>[reply]{subj}[/reply]</h3>
		{text}
		[signature]<br clear="all" />{signature}[/signature]
</div>
<span class="reply">[reply]Ответить[/reply]</span>
[/readpm]
</div>