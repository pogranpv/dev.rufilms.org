[searchposts]
	[fullresult]
		<div class="filmshort2">
			<div class="fs-img2">
				<span class="poster2">
					<a href="{full-link}">
						<img src="[xfvalue_poster]" alt="{title}" title="{title}">
					</a>
				</span>
			</div>
			<div class="fs-foot">
				<a href="{full-link}" class="fs-name"><b>{title}</b></a>
				<ul>
					<li>[xfvalue_original_title]</li>
				</ul>
			</div>
		</div>
	[/fullresult]
	[shortresult]
		<div class="dpad searchitem">
			<span>[result-link]{result-title}[/result-link]</span>
			<b>{result-date}</b> | {link-category} | Автор: {result-author}
		</div>
	[/shortresult]
[/searchposts]
[searchcomments]
	[fullresult]
		<div class="bcomment">
			<div class="dtop">
				<div class="lcol"><span><img src="{foto}" alt=""/></span></div>
				<div class="rcol">
					<ul class="reset">
						<li><h4>{result-author}</h4></li>
						<li>{result-date}</li>
					</ul>
				</div>
				<div class="clr"></div>
			</div>
			<div class="cominfo"><div class="dpad">
				[not-group=5]
				<div class="comedit">
					<ul class="reset">
						<li>[com-edit]Изменить[/com-edit]</li>
						<li>[com-del]Удалить[/com-del]</li>
					</ul>
				</div>
				[/not-group]
				<ul class="cominfo reset">
					<li>Регистрация: {registration}</li>
				</ul>
			</div>
			<span class="thide">^</span>
			</div>
			<div class="dcont">
				<h3 style="margin-bottom: 0.4em;">[result-link]{result-title}[/result-link]</span>
				{result-text}
				<div class="clr"></div>
			</div>
		</div>
	[/fullresult]
[shortresult]
<div class="dpad searchitem">
	<span>[result-link]{result-title}[/result-link]</span>
	<b>{result-date}</b> | {link-category} | Автор: {result-author} | [com-edit]Изменить[/com-edit] | [com-del]Удалить[/com-del]
</div>
[/shortresult]
[/searchcomments]