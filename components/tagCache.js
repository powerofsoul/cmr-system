tagCache = {};
var ajaxUrl = "https://astorian.local/wp-admin/admin-ajax.php";

function fillTagCache(){
  var success = (data) =>{
    tagCache = JSON.parse(data);
  }

  var data = {
      project_ids: globalInfo.tags
  }

  doAjaxRequest("get_crm_tags_from_projects", data, success );
}


function getTag(i) {
    return tagCache[i];
}

function importTag(url){
    var success = (data)=> {
        if(data == "0"){
            alert("Invalid url");
            return;
        }
        if(globalInfo.tags.indexOf(data) >=0 ){
            alert("Tag already exists");
            return;
        }
        globalInfo.tags.push(data);
        saveItems();
        fillTagCache();
        globalUpdate();
    }
  
    doAjaxRequest("crm_import_project", {project_url: url}, success);
}

function updateTag(a, b){
    return function (event, c) {
        a[b] = event.target.value.trim();
        
        var ajax_object = {
            project_id: a.id,
            key:b,
            value:a[b]
        }
        doAjaxRequest("crm_update_project_meta", ajax_object );
    }
}

function doAjaxRequest(action, data, success = ()=>{}){;
    data.action = action;
    $("html").LoadingOverlay("show");
    jQuery.ajax({
        type:"POST",
        url: ajaxUrl,
        data: data,
        success:function(data){
            success(data);
            $("html").LoadingOverlay("hide");
            globalUpdate();
        },
        error: function(){
            alert("An error has occured please try again later");
        } 
      
    });
}

function mapTagsProperty(property){
    var result = [];
    for (var k in tagCache){
        if (property in tagCache[k]) {
            result.push(tagCache[k][property]);
        }
    }

    return result;
}

function getProjectManagerIdByName(name){
    var projectId = -1;
    globalInfo.managers.forEach((e, id) => {
        if(e.name == name) projectId = id;
    });

    return projectId;
}