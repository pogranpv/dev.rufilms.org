[pmlist]
<div class="sortn"><h3>������ ���������</h3></div>
[/pmlist]
[newpm]
<div class="sortn"><h3>����� ���������</h3></div>
[/newpm]
[readpm]
<div class="sortn"><h3>���� ���������</h3></div>
[/readpm]
<div class="opr">
<div class="dpad">
<div class="pm_status">
	<div class="pm_status_head">��������� �����</div>
	<div class="pm_status_content">����� ������������ ��������� ��������� ��:
{pm-progress-bar}
{proc-pm-limit}% �� ������ ({pm-limit} ���������)
	</div>
</div>
<div style="padding-top:10px;">[inbox]�������� ���������[/inbox]<br /><br />
[outbox]������������ ���������[/outbox]<br /><br />
[new_pm]��������� ���������[/new_pm]</div>
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
				����:
			</td>
			<td><input type="text" name="name" value="{author}" class="f_input" /></td>
		</tr>
		<tr>
			<td class="label">
				����:<span class="impot">*</span>
			</td>
			<td><input type="text" name="subj" value="{subj}" class="f_input" /></td>
		</tr>
		<tr>
			<td class="label">
				���������:<span class="impot">*</span>
			</td>
			<td class="editorcomm">
			{editor}<br />
			<div class="checkbox"><input type="checkbox" id="outboxcopy" name="outboxcopy" value="1" /> <label for="outboxcopy">��������� ��������� � ����� "������������"</label></div>
			</td>
		</tr>
		[sec_code]
		<tr>
			<td class="label">
				���:<span class="impot">*</span>
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
				������� ��� �����, ���������� �� �����������:<span class="impot">*</span>
			</td>
			<td>
				<div>{recaptcha}</div>
			</td>
		</tr>
		[/recaptcha]
		[question]
			<tr>
				<td class="label">
					������:
				</td>
				<td>
					<div>{question}</div>
				</td>
			</tr>
			<tr>
				<td class="label">
					�����:<span class="impot">*</span>
				</td>
				<td>
					<div><input type="text" name="question_answer" id="question_answer" class="f_input" /></div>
				</td>
			</tr>
		[/question]
	</table>
	<div class="fieldsubmit">
		<button type="submit" name="add" class="fbutton voteb"><span>���������</span></button>
		<input type="button" class="fbutton voteb" onclick="dlePMPreview()" title="��������" value="��������" />
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
				<li>[complaint]������������[/complaint]</li>
				<li>[ignore]������������[/ignore]</li>
				<li>[del]�������[/del]</li>
			</ul>
	</div>
		<h3>[reply]{subj}[/reply]</h3>
		{text}
		[signature]<br clear="all" />{signature}[/signature]
</div>
<span class="reply">[reply]��������[/reply]</span>
[/readpm]
</div>