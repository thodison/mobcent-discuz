<!DOCTYPE html>
<html>
<head>
    <title>安米后台管理</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo $this->rootUrl; ?>/css/bootstrap-3.2.0.min.css">
    <link rel="stylesheet" href="<?php echo $this->rootUrl; ?>/css/bootstrap-theme-3.2.0.min.css">
    <link rel="stylesheet" href="<?php echo $this->rootUrl; ?>/css/appbyme-admin-uidiy.css">
</head>
<body>

    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">APPbyme</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">网站首页</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">admin <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">退出</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <div id="uidiy-main-view">

    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <div id="mobleShow"></div>
            </div>

            <div class="col-md-8" id="operation">
                <p class="navCategory">选择导航样式</p>
                <div id="footNav">
                    <label><input type="radio"> 底部导航</label>
                </div>

                <p class="navCategory">模块管理</p>
                <div id="module-list">
                    <div class="module last-module">
                        <a href="#" data-toggle="modal" data-target=".module-edit-dlg" data-backdrop="" class="module-add-btn"><img title="模块1" src="<?php echo $this->rootUrl; ?>/images/admin/module-add.png" class="img-circle"></a>
                        <div>添加模块</div>
                    </div>
                </div>

                <div id="foot">
                    <p class="text-center">设置完成后请务必点击 
                        <button type="button" class="btn btn-primary btn-sm uidiy-sync-btn">同 步</button> 保证您所添加或设置的内容能在客户端显示！
                    </p> 
                </div>
            </div>
        </div>
    </div>
    
    <div id="module-edit-dlg-view">
    </div>
    <div id="module-remove-dlg-view">
    </div>

    </div>

    <script type="text/javascript">
    var uidiyGlobalObj = {
        rootUrl: '<?php echo $this->rootUrl; ?>',
        moduleInitParams: <?php echo WebUtils::jsonEncode(AppbymeUIDiyModel::initModule()); ?>,
        componentInitParams: <?php echo WebUtils::jsonEncode(AppbymeUIDiyModel::initComponent()); ?>,
        moduleInitList: <?php echo WebUtils::jsonEncode($modules); ?>,
    };
    <?php
    $reflect = new ReflectionClass('AppbymeUIDiyModel');
    foreach ($reflect->getConstants() as $key => $value) {
        echo "var {$key} = '$value';";
    }
    ?>
    var SUBNAV_MAX_COMPONENT_LEN = 4;
    </script>
    <script src="<?php echo $this->rootUrl; ?>/js/jquery-2.0.3.min.js"></script>
    <script src="<?php echo $this->rootUrl; ?>/js/bootstrap-3.2.0.min.js"></script>
    <script src="<?php echo $this->rootUrl; ?>/js/underscore-1.7.0.min.js"></script>
    <script src="<?php echo $this->rootUrl; ?>/js/backbone-1.1.2.min.js"></script>
    <script src="<?php echo $this->rootUrl; ?>/js/admin/uidiy.js"></script>
    <script type="text/template" id="module-template">
    <div class="module" id="module-id-<%= id %>">
        <img title="<%- title %>" src="<%= icon %>" class="img-thumbnail">
        <div><%- title %></div>
        <div>
            <button class="module-edit-btn" data-toggle="modal" data-target=".module-edit-dlg" data-backdrop="">编辑</button>
            <% if (id != MODULE_ID_FASTPOST && id != MODULE_ID_DISCOVER) { %>
            <button class="module-remove-btn" data-toggle="modal" data-target=".module-remove-dlg" data-backdrop="">删除</button>
            <% } %>
        </div>
    </div>
    </script>
    <script type="text/template" id="module-edit-template">
    <div class="modal fade bs-example-modal-lg module-edit-dlg" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title"><%= id != 0 ? '编辑模块' : '添加模块' %></h4>
            </div>
            <form class="module-edit-form form-horizontal" method="get">
            <div class="modal-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">编辑名称：</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control sm" name="moduleTitle" value="<%- title %>" placeholder="">
                        <p class="help-block">请输入1-4个字母、数字或汉字作为名称</p>
                    </div>
                </div>

                <div class="form-group hidden">
                    <label for="" class="col-sm-2 control-label">编辑图标：</label>
                    <div class="col-sm-10">
                        <input type="file" id="" >
                        <p class="help-block">请上传1:1比例的JPG或PNG格式图片作为图标</p>
                    </div>
                </div>

                <div class="form-group hidden">
                    <div class="col-sm-offset-2 col-sm-10">
                        <img src="" style="width:100px;height:100px;" class="img-rounded">
                    </div>
                </div>
                <% var isModuleTypeSelect = id != MODULE_ID_FASTPOST && id != MODULE_ID_DISCOVER; %>
                <div class="<%= !isModuleTypeSelect ? 'hidden' : '' %>">
                    <label>模块样式: </label>
                    <select id="moduleType" name="moduleType">
                        <option value="<%= MODULE_TYPE_FASTPOST %>" <%= type == MODULE_TYPE_FASTPOST ? 'selected' : '' %> class="<%= isModuleTypeSelect ? 'hidden' : '' %>">快速发帖</option>
                        <option value="<%= MODULE_TYPE_FULL %>" <%= type == MODULE_TYPE_FULL ? 'selected' : '' %>>单页面</option>
                        <option value="<%= MODULE_TYPE_SUBNAV %>" <%= type == MODULE_TYPE_SUBNAV ? 'selected' : '' %>>二级导航</option>
                        <option value="<%= MODULE_TYPE_NEWS %>" <%= type == MODULE_TYPE_NEWS ? 'selected' : '' %>>左图右文</option>
                        <option value="<%= MODULE_TYPE_CUSTOM %>" <%= type == MODULE_TYPE_CUSTOM ? 'selected' : '' %>>自定义页面</option>
                    </select>
                </div>
                <div id="module-edit-detail">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
                <input type="submit" class="btn btn-primary" value="确定" >  
            </div>
            </form>
        </div>
      </div>
    </div>
    </script>
    <script type="text/template" id="module-edit-detail-template">
    <% if (id == MODULE_ID_DISCOVER) { %>
    <% } else if (id == MODULE_ID_FASTPOST) { %>
    <div class="edit">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">编辑内容：</label>
            <div class="col-sm-2">
                <div class="text-center">
                    <img src="" style="width:80px;height:80px;" class="img-rounded">
                    <p><small>发表文字</small></p>
                </div>
            </div>
            <div class="form-group col-sm-8">
                <div class="pull-left edit-middle">
                    <label for="" class="">发表版块：</label>
                </div>
                <div class="pull-left edit-right">
                    <select class="input-sm">
                        <option selected="" value="用户自选版块">用户自选版块</option>
                        <option value="版块一">版块一</option>
                        <option value="版块二">版块二</option>
                        <option value="版块三">版块三</option>
                        <option value="版块四">版块四</option>
                    </select>
                    <div class="checkbox">
                        <label><input type="checkbox" value=""><small>勾选则需用户填写标题</small></label>
                    </div>                        
                    <div class="checkbox">
                        <label><input type="checkbox" value=""><small>勾选则显示主题分类</small></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <label for="" class="control-label">选择发表项：</label>
                <select class="input-sm">
                    <option selected="" value="发表文字">发表文字</option>
                    <option value="发表图片">发表图片</option>
                    <option value="拍照发表">拍照发表</option>
                    <option value="发表语音">发表语音</option>
                    <option value="签到">签到</option>
                </select>                        
                <button type="button" class="btn btn-primary btn-sm">添加</button>
                <button type="button" class="btn btn-primary btn-sm">取消</button>
            </div>
        </div>
    </div>
    <% } else if (type == MODULE_TYPE_FULL) { %>
    <div class="component-view-container"></div>
    <% } else if (type == MODULE_TYPE_SUBNAV) { %>
    <div><label>添加导航: </label></div>
    <div class="component-view-container"></div>
    <div class="component-view-container"></div>
    <div class="component-view-container"></div>
    <div class="component-view-container"></div>
    <% } else if (type == MODULE_TYPE_NEWS) { %>
        <h5>请在左侧预览图中设置添加内容</h5>
    <% } else if (type == MODULE_TYPE_CUSTOM) { %>
        <h5>请在左侧预览图中设置添加内容</h5>
    <% } %> 
    </script>
    <script type="text/template" id="module-remove-template">
    <div class="modal fade bs-example-modal-sm module-remove-dlg" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">删除模块</h4>
            </div>
            <form class="module-remove-form">
            <div class="modal-body">
                <h5>是否要删除 <%- title %> 模块</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
                <input type="submit" class="btn btn-primary" value="确定" >  
            </div>
            </form>
        </div>
      </div>
    </div>
    </script>
    <script type="text/template" id="component-template">
    <div class="component-view" id="component-view-<%= id %>">
        <div>
            <input type="text" name="componentTitle[]" value="<%= title %>">
        </div>
        <div>
            <small>链接地址：</small>
            <select name="componentType[]" class="selectComponentType">
                <option value="<%= COMPONENT_TYPE_FORUMLIST %>" <%= type == COMPONENT_TYPE_FORUMLIST ? 'selected' : '' %>>版块列表</option>
                <option value="<%= COMPONENT_TYPE_NEWSLIST %>" <%= type == COMPONENT_TYPE_NEWSLIST ? 'selected' : '' %>>资讯列表</option>
                <option value="<%= COMPONENT_TYPE_TOPICLIST %>" <%= type == COMPONENT_TYPE_TOPICLIST ? 'selected' : '' %>>简版帖子列表</option>
                <option value="<%= COMPONENT_TYPE_MESSAGELIST %>" <%= type == COMPONENT_TYPE_MESSAGELIST ? 'selected' : '' %>>消息列表</option>
                <option value="<%= COMPONENT_TYPE_SURROUDING_USERLIST %>" <%= type == COMPONENT_TYPE_SURROUDING_USERLIST ? 'selected' : '' %>>周边用户</option>
                <option value="<%= COMPONENT_TYPE_SURROUDING_POSTLIST %>" <%= type == COMPONENT_TYPE_SURROUDING_POSTLIST ? 'selected' : '' %>>周边帖子</option>
                <option value="<%= COMPONENT_TYPE_RECOMMEND_USERLIST %>" <%= type == COMPONENT_TYPE_RECOMMEND_USERLIST ? 'selected' : '' %>>推荐用户</option>
                <option value="<%= COMPONENT_TYPE_SETTING %>" <%= type == COMPONENT_TYPE_SETTING ? 'selected' : '' %>>设置</option>
                <option value="<%= COMPONENT_TYPE_ABOAT %>" <%= type == COMPONENT_TYPE_ABOAT ? 'selected' : '' %>>关于</option>
                <option value="<%= COMPONENT_TYPE_WEBAPP %>" <%= type == COMPONENT_TYPE_WEBAPP ? 'selected' : '' %>>外部wap页</option>
            </select>
        </div>
        <div id="component-view-<% print(COMPONENT_TYPE_FORUMLIST+'-'+id) %>" class="component-view-item <%= type == COMPONENT_TYPE_FORUMLIST ? '' : 'hidden' %>">
            <div>
                <small>设置样式: </small>
                <label>
                    <input type="checkbox" name="isShowForumIcon[]" <%= extParams.isShowForumIcon ? 'checked' : '' %>><small>勾选则显示图标</small>
                </label>
                <label>
                    <input type="checkbox" name="isShowForumTwoCols[]" <%= extParams.isShowForumTwoCols ? 'checked' : '' %>> <small>勾选则双栏显示</small>
                </label>
            </div>
        </div>
        <div id="component-view-<% print(COMPONENT_TYPE_NEWSLIST+'-'+id) %>" class="component-view-item <%= type == COMPONENT_TYPE_NEWSLIST ? '' : 'hidden' %>">
            <div>                                 
                <small>选择门户: </small>
                <select name="newsModuleId[]">
                <?php foreach ($newsModules as $newsModule) { ?>
                    <option value="<?php echo $newsModule['mid'] ?>"><?php echo $newsModule['name'] ?></option> 
                <?php } ?>
                </select> 
            </div>
        </div>
        <div id="component-view-<% print(COMPONENT_TYPE_TOPICLIST+'-'+id) %>" class="component-view-item <%= type == COMPONENT_TYPE_TOPICLIST ? '' : 'hidden' %>">
        </div>
        <div id="component-view-<% print(COMPONENT_TYPE_MESSAGELIST+'-'+id) %>" class="component-view-item <%= type == COMPONENT_TYPE_MESSAGELIST ? '' : 'hidden' %>">
        </div>
        <div id="component-view-<% print(COMPONENT_TYPE_SURROUDING_USERLIST+'-'+id) %>" class="component-view-item <%= type == COMPONENT_TYPE_SURROUDING_USERLIST ? '' : 'hidden' %>">
        </div>
        <div id="component-view-<% print(COMPONENT_TYPE_SURROUDING_POSTLIST+'-'+id) %>" class="component-view-item <%= type == COMPONENT_TYPE_SURROUDING_POSTLIST ? '' : 'hidden' %>">
        </div>
        <div id="component-view-<% print(COMPONENT_TYPE_RECOMMEND_USERLIST+'-'+id) %>" class="component-view-item <%= type == COMPONENT_TYPE_RECOMMEND_USERLIST ? '' : 'hidden' %>">
        </div>
        <div id="component-view-<% print(COMPONENT_TYPE_SETTING+'-'+id) %>" class="component-view-item <%= type == COMPONENT_TYPE_SETTING ? '' : 'hidden' %>">
        </div>
        <div id="component-view-<% print(COMPONENT_TYPE_ABOAT+'-'+id) %>" class="component-view-item <%= type == COMPONENT_TYPE_ABOAT ? '' : 'hidden' %>">
        </div>
        <div id="component-view-<% print(COMPONENT_TYPE_WEBAPP+'-'+id) %>" class="component-view-item <%= type == COMPONENT_TYPE_WEBAPP ? '' : 'hidden' %>">
            <div>
                <small>wap地址: </small>
                <input type="text" name="componentRedirect[]" value="">
            </div>
        </div>
        <div>                                 
            <small>页面样式: </small>
            <select name="componentStyle[]">
                <option value="<%= COMPONENT_STYLE_FLAT %>" <%= style == COMPONENT_STYLE_FLAT ? 'selected' : '' %>>扁平样式</option>
                <option value="<%= COMPONENT_STYLE_CARD %>" <%= style == COMPONENT_STYLE_CARD ? 'selected' : '' %>>卡片样式</option>
                <option value="<%= COMPONENT_STYLE_IMAGE %>" <%= style == COMPONENT_STYLE_IMAGE ? 'selected' : '' %>>图片样式</option>
            </select> 
        </div>
    </div>
    </script>
</body>
</html>