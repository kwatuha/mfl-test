function createUploadForm(displayhere,fileType,title){

var obj=document.getElementById(displayhere);

obj.innerHTML='';


Ext.onReady(function() {
Ext.tip.QuickTipManager.init();
Ext.apply(Ext.form.VTypes, {
            payrollFileUpload: function (val, field) {
                var fileName = /^.*\.(pdf)$/i;
                return fileName.test(val);
            },
            payrollFileUploadText: 'Payroll file must be in .pdf format'
        });


        Ext.apply(Ext.form.VTypes, {
            contactUpload: function (val, field) {
                var fileName = /^.*\.(csv)$/i;
                return fileName.test(val);
            },
            contactUploadText: 'File must be in .csv format'
        });

var formWin = Ext.create('Ext.window.Window', {
            id: 'uploadForm',
            width:550,
            height:300,
            title: false,
            autoScroll: true,
            border: false,
            renderTo:'center-info-v',
            layout: 'fit',
            closable:true,
            maximizable:false,
            animCollapse:false,
            constrainHeader:true,
            bodyPadding: 15,
            resizable:true,
            title:title,
            defaults: { anchor: '100%' },
            fieldDefaults: {
                        labelAlign: 'left',
                        msgTarget: 'none'

                    },
            items: [
                 {
                        border: true,
                        xtype: 'form',
                        items: [
            {
                        xtype: 'textfield',
                        name: 'name',
              			value:'',
                        fieldLabel: 'Facility Name',
                        allowBlank: false,
                        minLength: 1,
                        padding: '10 0 0 0',

              },
            {
                        xtype: 'textfield',
                        name: 'status',
              			value:'',
                        fieldLabel: 'Status',
                        allowBlank: false,
                        minLength: 1,

              },
            ],

            buttons: [{
                text: 'Save',
                handler: function () {
                    var form = this.up('form').getForm();
                    if (form.isValid()) {
                        form.submit({
                            url: 'server/add.php',
                            params  : {
                                    data: Ext.encode(form.getValues())
                                },
                            waitMsg: 'Saving Facilitty...',
                              callback: function(o,s,r) {
                                  var rs=Ext.decode(r.responseText);
                                  alert(rs);

                                }
                        });
                    }
                }
            }]
        }
    ]


        });

       formWin.show();

});

}


function deleteFacility(facilityCode) {
    Ext.Ajax.request({
        url: 'server/delete.php',
        method: 'post',
        params: { code: facilityCode },
        waitMsg: 'Deleting MFL Facility',
        success: function (fp, o) {
            Ext.Msg.alert('Success', 'Facility has been Deleted');
        },
        failure: function (fp, o) {
            Ext.Msg.alert('Error', 'Facility could not be deleted');
        }
    });
}

function removedeleteFacilityOnConfirmation(facilitycode, title) {
    Ext.Msg.confirm('Confirm Delete', title,
        function (id, value) {
            if (id === 'yes') {
                deleteFacility(facilitycode);
                facilityDisplay();
            }
        }, this);


}

function showloginerror(errorid,title){
    Ext.Msg.show({
        title:title,
        msg: errorid,
        buttons: Ext.Msg.OK,
        icon: Ext.Msg.ERROR
    });
}