function facilityDisplay() {
    var toolBars = [{
                text: 'Add Facility',
                icon   : 'ext/shared/icons/fam/add.gif',
                id: 'addfacility',
                handler: function () {
                    createUploadForm('center-info-v', 'addfacility','Add Facility');
                }
            }, '-'


];
    createDisplayView( 'facility','center-info-v','Master Facility List',toolBars);

}

function createDisplayView( searchitem,display,title,toolBars){
var viewdiv=document.getElementById(display);
viewdiv.innerHTML='';
Ext.onReady(function() {
Ext.QuickTips.init();
var closebtn= Ext.get('close-btn');
	Ext.define('GridViewDataModel', {
    extend: 'Ext.data.Model',
	fields:[
            { name: 'code', type: 'string' },
            { name: 'name', type: 'string' },
            { name: 'status', type: 'string' }
        ]
	});
	var store = Ext.create('Ext.data.Store', {
    model: 'GridViewDataModel',

    proxy: {
        type: 'ajax',
         url: 'server/read.php?facilityType=' + searchitem,
        reader: {
             type: 'json',
                totalProperty: 'total',
                root: 'data',
                successProperty: 'success',
                idProperty: 'id',
        }
    }
});
  store.load({pageSize:50});
       var gridWin = Ext.create('Ext.window.Window', {
            id: 'estsearchforms',
            width:900,
            height: 480,
            title: false,
            autoScroll: true,
            border: false,
            renderTo:'center-info-v',
            layout: 'fit',
            closable:true,
            maximizable:true,
            animCollapse:false,
            constrainHeader:true,
            resizable:true,
            title:title,
            items: [
                    {
                        border: false,
                        xtype: 'grid',
                        tbar:toolBars,
                        store: store,
                        		bbar:{height: 20},
            dockedItems: [{
                    xtype: 'pagingtoolbar',
                    store: store,
                    dock: 'bottom',
                    displayInfo: true
                }],
             viewConfig: { stripeRows: true},
            columns: [
            new Ext.grid.RowNumberer({ width: 50, sortable: true }),
             { header: 'Facility Code', width: 120, sortable: true, id: 'code', dataIndex: 'code' },
            { header: 'Facility Name', width: 300, sortable: true, id: 'name', dataIndex: 'name' },

            { header: 'Status', width: 120, sortable: true, id: 'status', dataIndex: 'status' },


          {
                          menuDisabled: true,
                          sortable: false,
                          xtype: 'actioncolumn',
                          width: 80,
                          items: [
          				  {
                              icon   : 'ext/shared/icons/fam/delete.gif',
                              tooltip: 'Delete ',
                              handler: function(grid, rowIndex, colIndex) {

                                 var rec = store.getAt(rowIndex);
                                 var name=rec.get('name');
                                 var code=rec.get('code');
          						removedeleteFacilityOnConfirmation(code, 'Are you sure you want to delete '+name+'?');

                              }
                          },
                          {
                                                        icon   : 'ext/shared/icons/fam/editrow.gif',
                                                        tooltip: 'Edit ',
                                                        handler: function(grid, rowIndex, colIndex) {
                                                           var rec = store.getAt(rowIndex);
                                                           var ridtr=rec.get('name');

                                                        }
                            }
                          ]
                      }
        
        ],
        }
    ]
            

        });

       gridWin.show();

});
}

