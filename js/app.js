Ext.Loader.setConfig({
    enabled: true
});
Ext.Loader.setPath('Ext.ux', '../ext/ux');

Ext.require([
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.ux.RowExpander',
    'Ext.selection.CheckboxModel'
]);

function facilityViewPort() {

    var displayhere = 'landing-page';
    var loadtype = 'Save';
    var rid = 'NOID';
    var obj = document.getElementById(displayhere);
    obj.innerHTML = '';

  
             
        var win = Ext.create('Ext.window.Window', {
            title:  '<div class="app-loader-logo"></div>'+'<div class="app-title">Master Facility List</div>',
            bodyPadding: 10,
            autoScroll: true,
            maximizable: false,
            collapsible: true,
            closable: false,
            maximized: true,
            border: false,
            bodyBorder: false,
            bodyStyle: 'padding: 10px; background-color:#3d71b8',//; #DFE8F6
            margins:'50 0 0 0',
            id: 'idestatemgtwin',
            plain: true,
           html:'<div>'
           +'<ul class="home-view">'
              +' <li id="facility-list"><img src="ext/layout/images/grid48x48.png"/><a>MFL Facility</a></li>'
              +' <li id="facility-users"><img src="ext/layout/images/im48x48.gif"/><a>Users</a></li>'
              +' <li id="system_administration"><img src="ext/shared/icons/fam/chart48x48.png"/><a>Reports</a></li>'
           +'</ul>'       
           +'<div  class="display-view" id="center-info-v"></div>'
           +'</div>',
            buttonAlign: 'center'
        });

        win.show();    

       Ext.get('facility-list').on('click', function(event, target) {
        facilityDisplay();
         }, null, {delegate: 'img'});


}




