Ext.define('Seic.view.Projetos.buscaProjeto', {
    extend: 'Ext.window.Window',
    id: 'modprojetos_buscaProjetoo',
    alias: 'widget.modprojetos_buscaProjetoo',
    title: 'Busca avaçada de projetos',
    iconCls: 'projetos-minishortcut',
    bodyborder: false,
    border: false,
    width: 600,
    layout: {
        type: 'fit',
        align: 'stretch'
    },

    modal: true,
    constrain: true,
    closable: false,
    resizable: false,

    requires: [
        'Ext.ux.CpfField',
        'Ext.ux.textMask',
        'Ext.ux.ClearCombo'
    ],

    items: [{
        xtype: 'form',
        layout: 'column',
        defaults: { 
            allowBlank: true,
            padding: 3,
            anchor: '100%'
        },
        items: [{
            columnWidth: 0.5,
            border: false,
            items: [{
                xtype:'fieldset',
                columnWidth: 0.5,
                title: '-',
                height: 320,
                defaults: {
                    anchor: '100%'
                },
                items:[{  
                    xtype: 'cpffield',
                    name: 'cpf',
                    fieldLabel: 'CPF',
                    labelAlign: 'top',
                    labelWidth: 40,
                    anchor: '42%',
                    plugins: [{
                        ptype: 'ux.textMask',
                        mask: '999.999.999-99',
                        clearWhenInvalid: false
                    }]
                },{
                    xtype: 'textfield',
                    name: 'nome',
                    fieldLabel: 'Nome',
                    labelAlign: 'top',
                    labelWidth: 40
                },{
                    xtype: 'textfield',
                    name: 'email',
                    fieldLabel: 'E-mail',
                    labelAlign: 'top',
                    labelWidth: 40
                },{
                    xtype: 'textareafield',
                    fieldLabel: 'Título',
                    labelAlign: 'top',
                    name: 'titulo',
                    rows: 2,
                    grow: false,
                    labelWidth: 40
                },{
                    xtype: 'radiogroup',                    
                    fieldLabel: 'Apresentação obrigatória',
                    labelAlign: 'top',                    
                    columns: 2,
                    vertical: false,
                    items: [{ 
                        boxLabel: 'Sim', 
                        inputValue: '1',
                        name: 'apresentacao_obrigatoria'
                    },{ 
                        boxLabel: 'Não', 
                        inputValue: '0',
                        name: 'apresentacao_obrigatoria'                    
                    }]
                }]
            }]
        },{
            columnWidth: 0.5,
            border: false,
            items: [{
                xtype:'fieldset',
                columnWidth: 0.5,
                title: '-',
                defaults: {
                    anchor: '100%',
                    labelAlign: 'top',
                    xtype: 'clearcombo'
                },
                items:[{
                    name: 'fgk_area',
                    fieldLabel: 'Área',
                    store: 'Projetos.Area',
                    queryMode: 'remote',
                    displayField: 'codigo_area',
                    queryParam: 'filtro',
                    valueField: 'id_area',
                    labelWidth: 60
                },{
                    name: 'fgk_programa_ic',
                    fieldLabel: 'Programa',
                    store: 'Projetos.Programa_ic',
                    queryMode: 'local',
                    displayField: 'nome',
                    valueField: 'id',
                    labelWidth: 60,
                    queryParam: 'filtro'
                },{
                    name: 'fgk_orgao_fomento',
                    fieldLabel: 'Orgao fomento',
                    store: 'Projetos.Orgao',
                    queryMode: 'local',
                    displayField: 'sigla',
                    valueField: 'id',
                    labelWidth: 95
                },{
                    name: 'fgk_categoria',
                    fieldLabel: 'Categoria',
                    store: 'Projetos.Categoria',
                    queryMode: 'local',
                    displayField: 'sigla_categoria',
                    valueField: 'id_categoria',
                    labelWidth: 95
                },{
                    name: 'fgk_area_especifica',
                    fieldLabel: 'Área específica',
                    store: 'Projetos.AreaSpec',
                    queryMode: 'local',
                    displayField: 'descricao_area_especifica',
                    valueField: 'id',
                    labelWidth: 35
                },{                    
                    name: 'fgk_departamento',
                    fieldLabel: 'Departamento',
                    store: 'Projetos.Departamento',
                    queryMode: 'local',
                    displayField: 'id_departamento',
                    valueField: 'id_departamento',
                    labelWidth: 90
                }]
            }]
        }]
    }],

    dockedItems: [{
        xtype: 'toolbar',
        dock: 'bottom',
        border: false,
        bodyBorder: false,
        items: ['->',{
            text: 'Buscar',
            id: 'modprojetos_buscaBtnBuscar',
            iconCls: 'icon-search',
            width: 100
        },{
            text: 'Cancelar',
            id: 'modprojetos_buscaBtnCancelar',
            iconCls: 'icon-cancel',
            width: 100
        }]
    }]
});