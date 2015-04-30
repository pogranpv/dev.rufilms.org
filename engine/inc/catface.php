<?php

/*
=============================================================================
 ����: catface.php (backend) ������ 2.3
-----------------------------------------------------------------------------
 �����: ����� ��������� ����������, mail@mithrandir.ru
-----------------------------------------------------------------------------
 ����������: ��������� SEO ��� ��������� � ������� ��������
=============================================================================
*/

    // ���������
    if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
            die( "Hacking attempt!" );
    }

    /*
     * ����� ��������� SEO ��� ��������� � ������� ��������
     */
    class CategoryFaceAdmin
    {
        /*
         * ����������� ������ CategoryFaceAdmin - ����� �������� �������� dle_api � editor
         * @param $dle_api - ������ ������ DLE_API
         */
        public function __construct()
        {
            // ���������� DLE_API
            global $db, $config;
            include ('engine/api/api.class.php');
            $this->dle_api = $dle_api;
        }


        /*
         * ������� ����� ������ CategoryFaceAdmin - � ����������� �� �������, �������� �� ��� ���� ��������
         */
        public function run()
        {
            // ����� �������� action �� �������; �� ��������� action=list (������ �������)
            $action = !empty($_REQUEST['action'])?$_REQUEST['action']:'list';

            // � ����������� �� ��������� action, ��������� �� ��� ���� ��������
            switch($action)
            {
                // �������� ������ �������
                case 'list':
                    $output = $this->actionList();
                    $headerText = '������ ���������';
                    break;

                // ����� �������������� ����� ������ �� ������
                case 'form':
                    $output = $this->actionForm();
                    $headerText = '<a href="?mod=catface"><< ��������� � ������ ���������</a>';
                    break;

                // ���������� �������
                case 'save':
                    $output = $this->actionSave();
                    $headerText = '���������� ����������';
                    break;

                // ������ - �� ������������ action
                default:
                    $headerText = '������! ��������� ����������� ��������!';
                    break;
            }

            $this->showOutput($headerText, $output);
        }


        /*
         * ����� ���������� ������ ��������� � ���������� �������� ��� ������
         * @return string
         */
        public function actionList()
        {
            return '
            <table id="catslist" class="table table-normal" width="100%">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <th>���������</th>
                        <th>��������</th>
                    </tr>
                    <tr class="list_item">
                        <td height="20"><strong>0</strong></td>
                        <td height="20"><a href="?mod=catface&action=form&id=0">������� ��������</a></td>
                        <td height="20">[<a href="?mod=catface&action=form&id=0">�������������</a>]</td>
                    </tr>
                    '.$this->createCatsTable().'
                </tbody>
            </table>
            <script type="text/javascript">
                $(function(){
                        $("#catslist").delegate("tr.list_item", "hover", function(){
                          $(this).toggleClass("hoverRow");
                        });
                });
            </script>

            ';
        }


        /*
         * ����� ���������� ������ �� ����� �������������� ������ ���������
         * @param $parentId - ������������� ���������-��������
         * @param $subLevelMarker - ������ ��� �������� ������������
         * @return string ������� ���� ������������ �� ��������� ���������
         */
        public function createCatsTable($parentId = 0, $subLevelMarker = '')
        {
            // �������� ������ ������������ ��������� ���������
            $cats = $this->dle_api->load_table (PREFIX."_category", 'id, name', 'parentid = '.$parentId, true, 0, false, 'posi', 'ASC');

            // � ���������� $catsTable ����� ���������� ������ � ������� ��������� ��� ������
            $catsTable = '';

            // ���� ���-�� �������, ���������� ��� ��������� ���������
            if($cats)
            {
                foreach($cats as $cat)
                {
                    // ��������� � ������� ������� ���������
                    $catsTable .= '
                    <tr class="list_item">
                        <td height="20"><strong>'.$cat['id'].'</strong></td>
                        <td height="20">&nbsp;'.$subLevelMarker.'&nbsp;<a href="?mod=catface&action=form&id='.$cat['id'].'">'.$cat['name'].'</a></td>
                        <td height="20">[<a href="?mod=catface&action=form&id='.$cat['id'].'">�������������</a>] &nbsp; [<a href="?mod=categories&action=edit&catid='.$cat['id'].'">���������</a>]</td>
                    </tr>';

                    // ��������� ������������
                    $catsTable .= $this->createCatsTable($cat['id'], $subLevelMarker.'--');
                }
            }

            return $catsTable;
        }



        /*
         * ����� ���������� ����� �������������� ���������
         * @return string
         */
        public function actionForm()
        {
            // ������������ id ��������� �� �������
            $id = (int)$_REQUEST['id'];

            // ���� ��������������� ������ � ������� category_face
            $categoryFace = $this->dle_api->load_table (PREFIX."_category_face", '*', 'category_id = '.$id, false);

            // ������������ ���������� ����������
            global $lang, $config, $user_group, $member_id, $dle_login_hash;

            // ���������� ������
            include_once ENGINE_DIR . '/classes/parse.class.php';
            $parse = new ParseFilter( Array (), Array (), 1, 1 );

            // ���������� �������� wysiwyg
            if($this->dle_api->dle_config['allow_admin_wysiwyg'] && ($this->dle_api->dle_config['allow_admin_wysiwyg'] != "no") )
            {
                $categoryFace['description'] = $parse->decodeBBCodes($categoryFace['description'], true, $this->dle_api->dle_config['allow_admin_wysiwyg']);
                $categoryFace['description_pages'] = $parse->decodeBBCodes($categoryFace['description_pages'], true, $this->dle_api->dle_config['allow_admin_wysiwyg']);

		ob_start();
                include (ENGINE_DIR . '/editor/catface_description.php');
                ob_implicit_flush(false);
                $editor_description = ob_get_clean();

                ob_start();
                include (ENGINE_DIR . '/editor/catface_description_pages.php');
                ob_implicit_flush(false);
                $editor_description_pages = ob_get_clean();
            }

            // ���������� �������� bbcode
            else
            {
                $categoryFace['description'] = $parse->decodeBBCodes($categoryFace['description'], false);
                $categoryFace['description_pages'] = $parse->decodeBBCodes($categoryFace['description_pages'], false);

                $bb_editor = true;
                include (ENGINE_DIR . '/inc/include/inserttag.php');
		$editor_description = '
                <div class="form-group">
                    <label class="control-label col-xs-2">�������� ���������:</label>
                    <div class="col-xs-10">
						'.$bb_code.'<textarea class="bk" style="width:100%;max-width:950px;height:300px;" name="description" id="description"  onclick=setFieldName(this.name)>'.$categoryFace['description'].'</textarea><script type=text/javascript>var selField  = "description";</script>
					</div>
                </div>';

		$editor_description_pages = '
                <div id="description_pages_line" class="form-group">
                    <label class="control-label col-xs-2">�������� ��� ��������� �������:</label>
                    <div class="col-xs-10">
						'.$bb_code.'<textarea class="bk" style="width:100%;max-width:950px;height:300px;" name="description_pages" id="description_pages"  onclick=setFieldName(this.name)>'.$categoryFace['description_pages'].'</textarea><script type=text/javascript>var selField  = "description_pages";</script>
					</div>
                </div>';
            }

            return '
            <form method="POST" action="?mod=catface&action=save" class="form-horizontal">
                <div class="row box-section">
                        <div class="form-group">
                            <label class="control-label col-xs-2">��� ������������ ������:</label>
                            <div class="col-xs-3">
                                <input id="module_placement_nowhere" type="radio" name="module_placement" value="nowhere"'.(($categoryFace['module_placement'] == 'nowhere')?' checked':'').'> <label for="module_placement_nowhere">�����</label><br />
                                <input id="module_placement_first_page" type="radio" name="module_placement" value="first_page"'.(($categoryFace['module_placement'] == 'first_page')?' checked':'').'> <label for="module_placement_first_page">�� ������ ��������</label><br />
                                <input id="module_placement_all_pages" type="radio" name="module_placement" value="all_pages"'.(($categoryFace['module_placement'] == 'all_pages')?' checked':'').'> <label for="module_placement_all_pages">�� ���� ���������</label>
							</div>
							<div class="col-xs-6 note large">
								������ ����� ��������� ������ �� ��������� ��������� �� ������ �������� � ��������, �� � ��� ��������� ���������� tpl-�������:<br />
								<strong>�����</strong> - ����������� ������ � ������ ���������.<br />
								<strong>�� ������ ��������</strong> - ������ ����� ����������� �� ������ �������� ���������.<br />
								<strong>�� ���� ���������</strong> - ������ ����� ������������ �� ���� ��������� ���������.
                            </div>
                        </div>

						<hr />

                        <div class="form-group">
                            <label class="control-label col-xs-2">���������� ���������:</label>
                            <div class="col-xs-3">
                                <input id="show_name_show" type="radio" name="show_name" value="show"'.(($categoryFace['show_name'] == 'show')?' checked':'').'> <label for="show_name_show">����������</label><br />
                                <input id="show_name_default" type="radio" name="show_name" value="default"'.(($categoryFace['show_name'] == 'default')?' checked':'').'> <label for="show_name_default">�� ���������</label><br />
                                <input id="show_name_hide" type="radio" name="show_name" value="hide"'.(($categoryFace['show_name'] == 'hide')?' checked':'').'> <label for="show_name_hide">��������</label>
                            </div>
							<div class="col-xs-6 note large">
								<strong>����������</strong> - ���������� ���������, �� ����� ������������ � ������������ � ����������� ����� ����.<br />
								<strong>�� ���������</strong> - ������������ � �������� ��������� ��� ��������� (�� title), ������� �� ���������� �������� ���������.<br />
								<strong>��������</strong> - ������������ ���������, �.�. �� �������� �� ������������ �� �����.
							</div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">��������� ���������:</label>
                            <div class="col-xs-10">
								<input type="text" value="'.$categoryFace['name'].'" class="edit bk" style="width:98%;" size="25" name="name">
							</div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">��� ���������� ���������:</label>
                            <div class="col-xs-3">
                                <input id="name_placement_first_page" type="radio" name="name_placement" value="first_page"'.(($categoryFace['name_placement'] == 'first_page')?' checked':'').'> <label for="name_placement_first_page">�� ������ ��������</label><br />
                                <input id="name_placement_all_pages" type="radio" name="name_placement" value="all_pages"'.(($categoryFace['name_placement'] == 'all_pages')?' checked':'').'> <label for="name_placement_all_pages">�� ���� ���������</label>							
                            </div>
							<div class="col-xs-6 note large">
								<strong>�� ������ ��������</strong> - ��������� ����� ������������ ������ �� ������� �������� ���������.<br />
								<strong>�� ���� ���������</strong> - �������� ���������, �.�. ����� ������������ �� ���� ��������� ���������.
                            </div>
                        </div>
                        <div id="name_pages_separator"></div>
                        <div id="name_pages_line" class="form-group">
                            <label class="control-label col-xs-2">��������� ��� ��������� �������:</label>
                            <div class="col-xs-10">
								<input type="text" value="'.$categoryFace['name_pages'].'" class="edit bk" style="width:98%;" size="25" name="name_pages">
							</div>
                        </div>

						<hr />

                        <div class="form-group">
                            <label class="control-label col-xs-2">���������� ��������:</label>
                            <div class="col-xs-3">
                                <input id="show_description_show" type="radio" name="show_description" value="show"'.(($categoryFace['show_description'] == 'show')?' checked':'').'> <label for="show_description_show">����������</label><br />
                                <input id="show_description_default" type="radio" name="show_description" value="default"'.(($categoryFace['show_description'] == 'default')?' checked':'').'> <label for="show_description_default">�� ���������</label><br />
                                <input id="show_description_hide" type="radio" name="show_description" value="hide"'.(($categoryFace['show_description'] == 'hide')?' checked':'').'> <label for="show_description_hide">��������</label>
                            </div>
							<div class="col-xs-6 note large">
								<strong>����������</strong> - ���������� ��������, ��� ����� ������� �� ���������� ���� ����.<br />
								<strong>�� ���������</strong> - ������������ � �������� �������� meta-��� description ��������� (�� title), ������� �� ���������� �������� ���������.<br />
								<strong>C�������</strong> - ������������ ��������, �.�. �� �������� ��� ������������ �� �����.
                            </div>
                        </div>

                        '.$editor_description.'

                        <div class="form-group">
                            <label class="control-label col-xs-2">��� ���������� ��������:</label>
                            <div class="col-xs-3">
                                <input id="description_placement_first_page" type="radio" name="description_placement" value="first_page"'.(($categoryFace['description_placement'] == 'first_page')?' checked':'').'> <label for="description_placement_first_page">�� ������ ��������</label><br />
                                <input id="description_placement_all_pages" type="radio" name="description_placement" value="all_pages"'.(($categoryFace['description_placement'] == 'all_pages')?' checked':'').'> <label for="description_placement_all_pages">�� ���� ���������</label>
                            </div>
							<div class="col-xs-6 note large">
								<strong>�� ������ ��������</strong> - �������� ����� ������������ ������ �� ������� �������� ���������.<br />
								<strong>�� ���� ���������</strong> - �������� ��������, �.�. ����� ������������ �� ���� ��������� ���������.
                            </div>
                        </div>

                        <div id="description_pages_separator"></div>
                        '.$editor_description_pages.'
                </div>

				<div style="text-align:center;padding:15px;"><input type="submit" class="btn btn-lg btn-green" value="���������"></div>

                <input type="hidden" name="user_hash" value="'.$dle_login_hash.'" />
                <input type="hidden" name="id" value="'.$id.'" />
            </form>

            <script type="text/javascript">
                if(!document.getElementById("name_placement_first_page").checked)
                {
                    document.getElementById("name_pages_separator").style.display = "none";
                    document.getElementById("name_pages_line").style.display = "none";
                }
                if(!document.getElementById("description_placement_first_page").checked)
                {
                    document.getElementById("description_pages_separator").style.display = "none";
                    document.getElementById("description_pages_line").style.display = "none";
                }

                document.getElementById("name_placement_first_page").onclick = function(){
                    document.getElementById("name_pages_separator").style.display = "inherit";
                    document.getElementById("name_pages_line").style.display = "inherit";
                }
                document.getElementById("name_placement_all_pages").onclick = function(){
                    document.getElementById("name_pages_separator").style.display = "none";
                    document.getElementById("name_pages_line").style.display = "none";
                }

                document.getElementById("description_placement_first_page").onclick = function(){
                    document.getElementById("description_pages_separator").style.display = "inherit";
                    document.getElementById("description_pages_line").style.display = "inherit";
                }
                document.getElementById("description_placement_all_pages").onclick = function(){
                    document.getElementById("description_pages_separator").style.display = "none";
                    document.getElementById("description_pages_line").style.display = "none";
                }
            </script>
            ';
        }


        /*
         * ����� ��������� SEO - ���������� ��������� � ������� category_face
         * @return string
         */
        public function actionSave()
        {
            // ������������ ���������� ����������
            global $dle_login_hash, $user_group, $member_id, $config;

            // �������� �����
            if( $_REQUEST['user_hash'] == "" or $_REQUEST['user_hash'] != $dle_login_hash )
            {
                die( "Hacking attempt! User not found" );
            }

            // ��������� ������� id ���������
            if($_POST['id'] == '')
            {
                die('��������� �� �������!');
            }

            // ���������� ����� �������
            include_once ENGINE_DIR . '/classes/parse.class.php';
            $parse = new ParseFilter( Array (), Array (), 1, 1 );

            // ������������ ������ �� �����
            $id = $_POST['id'];
            $name = !empty($_POST['name'])?$_POST['name']:'';
            $name_pages = !empty($_POST['name_pages'])?$_POST['name_pages']:'';
            $module_placement = !empty($_POST['module_placement'])?$_POST['module_placement']:'all_pages';
            $show_name = !empty($_POST['show_name'])?$_POST['show_name']:'show';
            $name_placement = !empty($_POST['name_placement'])?$_POST['name_placement']:'all_pages';
            $description = !empty($_POST['description'])?$_POST['description']:'';
            $description_pages = !empty($_POST['description_pages'])?$_POST['description_pages']:'';
            $show_description = !empty($_POST['show_description'])?$_POST['show_description']:'show';
            $description_placement = !empty($_POST['description_placement'])?$_POST['description_placement']:'first_page';

            // ������������ ������ �� �����
            $id = intval($id);
            // $name = $this->dle_api->db->safesql($parse->process(trim(htmlspecialchars($name))));
            $name = $this->dle_api->db->safesql ($parse->process (trim (htmlspecialchars ($name, ENT_COMPAT, $config['charset']))));
            // $name_pages = $this->dle_api->db->safesql($parse->process(trim(htmlspecialchars($name_pages))));
            $name_pages = $this->dle_api->db->safesql ($parse->process (trim (htmlspecialchars ($name_pages, ENT_COMPAT, $config['charset']))));
            $module_placement = $this->dle_api->db->safesql($parse->process(trim(htmlspecialchars($module_placement))));
            $show_name = $this->dle_api->db->safesql($parse->process(trim(htmlspecialchars($show_name))));
            $name_placement = $this->dle_api->db->safesql($parse->process(trim(htmlspecialchars($name_placement))));
            $show_description = $this->dle_api->db->safesql($parse->process(trim(htmlspecialchars($show_description))));
            $description_placement = $this->dle_api->db->safesql($parse->process(trim(htmlspecialchars($description_placement))));

            // ������������ ����� ��������
            if (!$user_group[$member_id['user_group']]['allow_html'] )
            {
		$description = strip_tags($description);
                $description_pages = strip_tags($description_pages);
            }
            if($this->dle_api->dle_config['allow_admin_wysiwyg'] && ($this->dle_api->dle_config['allow_admin_wysiwyg'] != "no"))
            {
                $parse->allow_code = false;
            }

            $description = $parse->process($description);
            $description_pages = $parse->process($description_pages);

            if($this->dle_api->dle_config['allow_admin_wysiwyg'] && ($this->dle_api->dle_config['allow_admin_wysiwyg'] != "no"))
            {
		$description = $this->dle_api->db->safesql($parse->BB_Parse($description));
                $description_pages = $this->dle_api->db->safesql($parse->BB_Parse($description_pages));
            }
            else
            {
		$description = $this->dle_api->db->safesql($parse->BB_Parse($description, false));
                $description_pages = $this->dle_api->db->safesql($parse->BB_Parse($description_pages, false));
            }

            // ������ � ������, ���� ���-�� �� ������ ��������
            if($parse->not_allowed_text)
            {
		msg( "error", '������ ��� ����������', '������������ �������', "javascript:history.go(-1)" );
            }

            // ����������, ���������� �� ��������������� ������ � ������� category_face
            $categoryFace = $this->dle_api->load_table (PREFIX."_category_face", 'category_id', 'category_id = '.$id, false);

            // ���� ������ ��� ������������, ��������� �
            if(!empty($categoryFace))
            {
                $this->dle_api->db->query(
                    "UPDATE ".PREFIX."_category_face SET ".
                        "`name` = '$name', ".
                        "`name_pages` = '$name_pages', ".
                        "`module_placement` = '$module_placement', ".
                        "`show_name` = '$show_name', ".
                        "`name_placement` = '$name_placement', ".
                        "`description` = '$description', ".
                        "`description_pages` = '$description_pages', ".
                        "`show_description` = '$show_description', ".
                        "`description_placement` = '$description_placement' ".
                        "WHERE `category_id` = $id"
                );
            }

            // ���� ������ �� ������������, ��������� �
            else
            {
                $this->dle_api->db->query(
                    "INSERT INTO ".PREFIX."_category_face ".
                        "(`category_id`, `name`, `name_pages`, `module_placement`, `show_name`, `name_placement`, `description`, `description_pages`, `show_description`, `description_placement`) ".
                        "VALUES($id, '$name', '$name_pages', '$module_placement', '$show_name', '$name_placement', '$description', '$description_pages', '$show_description', '$description_placement')"
                );
            }

            // ������� ��������� �� �������� ����������
            msg("info", '���������� � ��������� ������� ���������!', '���������� � ��������� ������� ���������!', '?mod=catface');
        }


        /*
         * ����� ������� ��������� � �������
         * @param $headerText - ����� ��������� ��������
         * @param $output - �������� ����������������� ������� ��� ������ � �������
         */
        public function showOutput($headerText, $output)
        {
            // ����������� ����� ���������� ����������
            echoheader('CatFace', '������ SEO-����������� ���������');
            echo '

'.($config['version_id'] >= 10.2 ? '<style>.uniform, div.selector {min-width: 250px;}</style>' : '<style>
@import url("engine/skins/application.css");

.box {
margin:10px;
}
.uniform {
position: relative;
padding-left: 5px;
overflow: hidden;
min-width: 250px;
font-size: 12px;
-webkit-border-radius: 0;
-moz-border-radius: 0;
-ms-border-radius: 0;
-o-border-radius: 0;
border-radius: 0;
background: whitesmoke;
background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi�pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==");
background-size: 100%;
background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #ffffff), color-stop(100%, #f5f5f5));
background-image: -webkit-linear-gradient(top, #ffffff, #f5f5f5);
background-image: -moz-linear-gradient(top, #ffffff, #f5f5f5);
background-image: -o-linear-gradient(top, #ffffff, #f5f5f5);
background-image: linear-gradient(top, #ffffff, #f5f5f5);
-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
border: 1px solid #ccc;
font-size: 12px;
height: 28px;
line-height: 28px;
color: #666;
}
</style>').'

<div class="box">
	<div class="box-header">
		<div class="title">'.$headerText.'</div>
		<ul class="box-toolbar">
			<li class="toolbar-link">
			<a target="_blank" href="http://alaev.info/blog/post/2086?from=CatFaceAdmin">CatFace v.2.3 � 2014 ���� ������\'� - ���������� � ��������� ������</a>
			</li>
		</ul>
	</div>

	<div class="box-content">
		'.$output.'
	</div>
</div>

            ';

            // ����������� ������� ���������� ����������
            echofooter();
        }
    }
    /*---End Of CategoryFaceAdmin Class---*/

    // ������ ������ ������ CategoryFaceAdmin
    $CategoryFaceAdmin = new CategoryFaceAdmin;

    // ��������� ������� ����� ������
    $CategoryFaceAdmin->run();

?>