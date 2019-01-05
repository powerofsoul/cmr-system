//global variables
globalInfo = {tags: [], managers:{}, items: [] }
globalView = 'CRM';
globalUpdate = ()=>{};

archiveInfo = [];
archivedTag = {href:"", items:[]};
lastModified = new Date(0);
//end of global variable


function saveItems() {
    $.post("utils.php", { requestType: "write", records: JSON.stringify(globalInfo), token: new Date().getTime() }, (data) => {
        console.log(data);
    });
}

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}

function getLastId() {
    if (globalInfo.items.length == 0) return 0;
    return Math.max(...globalInfo.items.map(e => e.id));
}

function updateValue(a, b){
    return function (event, c) {
        if (event.target.type == "checkbox") {
            a[b] = event.target.checked;
        } else {
            a[b] = event.target.value.trim();
        }
        globalUpdate();
        saveItems();
    }
}

function changeView(selectedView){
    globalView = selectedView;
    globalUpdate();
    $('.table').floatThead(); 
}

function getLastModified(){
    return lastModified.toLocaleDateString("en-US") + " " + lastModified.toLocaleTimeString();
}

function viewCalls(id){
    changeView("ArchivedTag");
    $.post("utils.php", { requestType: "read", file: `archive\\${id}.json`, token: new Date().getTime() }, function (data) {
        archivedTag = JSON.parse(data);
        globalUpdate();
    });         
}

function getProjectManager(id){
    return globalInfo.managers[id];
}