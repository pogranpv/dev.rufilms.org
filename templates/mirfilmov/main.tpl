<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    {headers}
    <link rel="search" type="application/opensearchdescription+xml" href="/engine/opensearch.php" title="" />
    <link rel="alternate" type="application/rss+xml" title="" href="rss.xml" />
    <script type="text/javascript" src="http://yastatic.net/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://yastatic.net/jquery-ui/1.9.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{THEME}/js/dle_js.js"></script>
    <link rel="shortcut icon" href="favicon.ico" />
    <link href="{THEME}/style/styles.css" type="text/css" rel="stylesheet" />
    <link href="{THEME}/style/engine.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="{THEME}/js/jquery.slider.js"></script>
    <script type="text/javascript" src="{THEME}/js/libss.js"></script>
    <script type="text/javascript" src="{THEME}/js/libs.js"></script>
    <!--[if lt IE 9]> 
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> 
	<![endif]-->
</head>
<body>
    <div class="wrp">
        <header>
			{include file="engine/modules/menulist.php"}
        </header>
        <div id="toolbar">
            <a class="logo" href="/" title="������ �� �������"></a>
            <form id="searchbar" method="post" action="">
                <input type="hidden" name="do" value="search">
                <input type="hidden" name="subaction" value="search">
                <div class="searchbar">
                    <button type="submit">�����</button>
                    <input id="story" name="story" value="" placeholder="��������� ��������" type="text" autocomplete="off">
                    <a href="/?do=search" class="searchadv">����������� �����</a>
                </div>
            </form>
        </div>
		<div id="whbox" class="clrfix">
			<div id="lside" class="lcol">
				[not-aviable=main]
					{content}
				[/not-aviable]
				[aviable=main]
					<h2 class="btl">��� ������ �� ����������</h2>
					{custom template="index-top" order="reads" limit="3"}
					<h2 class="btl">����� ������ ������</h2>
					{custom category="1,2,3,4,5" template="index-newfilm" order="date" limit="12"}
					<h2 class="btl">����� ������� ������</h2>
					{custom category="6" template="index-newserial" order="date" limit="12"}
				[/aviable]
				[aviable=cat]
					{include file="engine/modules/catface.php"}
				[/aviable]
			</div>
			<aside class="rcol">
				<h3 class="btl">����� �����</h3>
				<div class="box box-scroll">
					<div class="film-lines">
						{custom category="1,2,3,4,5" template="last-pub" order="date" limit="5"}
					</div>
				</div>
				<h3 class="btl">����� ������</h3>
				<div class="box box-scroll">
					<div class="film-lines">
						{custom category="6" template="last-pub" order="date" limit="5"}
					</div>
				</div>
			</aside>
		</div>
        <div id="footbar">
            <nav>
                <a href="/film">������</a>
                <a href="/serials">�������</a>
                <a href="/multfilms">�����������</a>
                <a href="/tv">��-��������</a>
                <a href="/index.php?do=feedback">�������� �����</a>
                <a href="/pravoobladatelyam.html">����������������</a>
            </nav>
            <!--noindex-->
            <div class="statist"></div>
            <!--/LiveInternet-->
            <!-- Yandex.Metrika informer -->
            <div class="statist"></div>
            <!--/noindex-->
        </div>
        <footer>
            <div class="copy">2015 � <a href="http://Filmcatch.ru/">Filmcatch.ru</a> � HD ������ � ������� �������� ������ ��������� � ������� �������� hd 720
                <br>�� ��������� ������ �� ������������� ������, �������, �����������, ��� ��� �� ������ �������� ������ 720 hd.
                <br>��������� � ��������� ������� ����� �� ����� ��������������� �� ������������� � ���������� ������ � ����������, �������������� �� ���� �����.</div>

        </footer>
    </div>
</body>

</html>