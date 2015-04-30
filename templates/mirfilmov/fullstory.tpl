<div id="dle-content">
    <div class="fullstory">
        <h2 class="btl">{title}</h2>
        <div class="movieinfo clrfix">
            <ul class="listing rcol">
				[xfgiven_original_title] 
				<li><span class="list-L">Оригинал:</span>
                    <p class="list-R">[xfvalue_original_title]</p>
                </li>
				[/xfgiven_original_title] 
				<li><span class="list-L">Жанр фильма:</span>
                    <p class="list-R">{category}</p>
                </li>
				[xfgiven_year]
				<li><span class="list-L">Год выпуска:</span>
                    <p class="list-R">[xfvalue_year]</p>
                </li>
				[/xfgiven_year]
				[xfgiven_director]
				<li><span class="list-L">Режиссёр:</span>
                    <p class="list-R">[xfvalue_director]</p>
                </li>
				[/xfgiven_director]
				[xfgiven_cast]
				<li><span class="list-L">Актёры:</span>
                    <p class="list-R">[xfvalue_cast]</p>
                </li>
				[/xfgiven_cast]
				[xfgiven_quality]
				<li><span class="list-L">Качество:</span>
                    <p class="list-R">[xfvalue_quality]</p>
                </li>
				[/xfgiven_quality]
				[xfgiven_audio]
				<li><span class="list-L">Озвучивание:</span>
                    <p class="list-R">[xfvalue_audio]</p>
                </li>
				[/xfgiven_audio]
            </ul>
            <div class="fs-img lcol">
                <span class="poster">
					<img src="[xfvalue_poster]" alt="{title}" title="{title}">
				</span>
            </div>
        </div>
        <div class="scont clrfix">
            <div style="display:inline;">Информация о {title}:
                <p itemprop="description">
					{short-story}
				</p>
            </div>
        </div>
        <div class="shareline clrfix">
            <div class="ratefull">
                <div class="rate">
                    <span class="small">Просмотров: {views}</span>
                </div>
            </div>
        </div>
    </div>
    <div id="lcs-13" class="ListCinemaSeans">
        <div class="title">
            <h1 itemprop="name">{title} смотреть онлайн в хорошем качестве HD</h1></div>
			<div class="seansitem">
				<script>
					var ser_list = new Array();
				</script>
				<table border="0" cellpadding="0" cellspacing="0" style="margin: 0px 0 0 0px;">
					<tbody>
						<tr>
							<td width="589">
								<div class="viboom-overroll">
									<script>
										ser_list[1] = '[xfvalue_trailer]';
									</script>
									<div id="source1" style="display: none">
									</div>
									
									<div id="content" style="margin-bottom: 6px;">
										<iframe width="589" height="349" src="[xfvalue_trailer]" frameborder="0" allowfullscreen></iframe>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="source-links">
									<a href="javascript://" onclick="toggle(&quot;source1&quot;,1);">Трейлер</a>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
        </div>
        <div class="clr"></div>
    </div>
    <center>
        <h2 style="margin:15px;color: #B0B0B0;font-size: 13px !important;font-family: Tahoma, verdana;">Смотреть фильм Большой матч онлайн в хорошем качестве</h2>
		<div>
			<div class="fullstory">
				<div class="fullstoryss">
					[xfgiven_links]
						<h2>Скачать {title} бесплатно</h2>
						<div class="links">
							<!--noindex-->[xfvalue_links]<!--/noindex-->
						</div>
					[/xfgiven_links]
					
					[xfgiven_torrent]<br />
						Скачать через torrent
						<div class="links">
							[xfvalue_torrent]
						</div>
					[/xfgiven_torrent]
				</div>
			</div>
		</div>
    </center>
    <script type="text/javascript">
        function toggle(id, a) {
            $("#content").html('<iframe width="589" height="349" src="' + ser_list[a] + '" frameborder="0" allowfullscreen></iframe>');
        }
        toggle("source1", 1);
    </script>
	<div class="rel">
		{addcomments}
		[comments]
			{comments}
			{navigation}
		[/comments]
	</div>
</div>