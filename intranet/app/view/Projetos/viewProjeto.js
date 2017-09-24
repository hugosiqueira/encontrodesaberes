Ext.define('Seic.view.Projetos.viewProjeto', {
    extend: 'Ext.window.Window',
    alias: 'widget.modprojetos_viewprojeto',
    title: 'Adicionar novo projeto',
    iconCls: 'projetos-minishortcut',
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
        'Ext.ux.textMask'
    ],

    items: [{
        xtype: 'form',
        defaults: {
            allowBlank: false,
            padding: 3,
            border: false
        },
        items: [{
            layout: 'vbox',
            items: [{
                xtype: 'panel',
                title: 'Fieldset orientador e aluno',
                header: false,
                border: false,
                width: 780,
                flex: 4,
                layout: 'column',
                items: [{
                    xtype: 'panel',
                    border: false,
                    bodyBorder: false,
                    layout: 'fit',
                    columnWidth: 0.5,
                    padding: '0 3 0 0', //(top, right, bottom, left)
                    items: [{
                        xtype: 'fieldset',
                        title: 'Orientador',
                        id: 'modprojetos_viewFieldsetOrientador',
                        items: [{
                            layout: 'hbox',
                            border: false,
                            items: [{
                                xtype: 'cpffield',
                                itemId: 'modprojetos_cpfOrientador',
                                fieldLabel: 'CPF',
                                name: 'orientador_cpf',
                                allowBlank: false,
                                labelWidth: 50,
                                width: 200,
                                padding: '0 10 0 0',
                                plugins: [{
                                    ptype: 'ux.textMask',
                                    mask: '999.999.999-99',
                                    clearWhenInvalid: false
                                }]
                            },{
                                xtype: 'button',
                                iconCls: 'icon-search-white',
                                itemId: 'btnBuscaOrientador'
                            }]
                        },{
                            xtype: 'displayfield',
                            id: 'modprojetos_FormNomeOrientador',
                            name: 'orientador',
                            fieldLabel: 'Nome',
                            submitValue: true,
                            allowBlank: false,
                            labelWidth: 50
                        },{
                            xtype: 'displayfield',
                            id: 'modprojetos_FormEmailOrientador',
                            name: 'orientador_email',
                            fieldLabel: 'E-mail',
                            submitValue: true,
                            allowBlank: false,
                            labelWidth: 50
                        },{
                            xtype: 'displayfield',
                            id: 'modprojetos_FormDepartamentoOrientador',
                            name: 'fgk_departamento_orientador',
                            fieldLabel: 'Departamento',
                            allowBlank: true,
                            labelWidth: 84
                        }]
                    }]
                },{
                    xtype: 'panel',
                    border: false,
                    bodyBorder: false,
                    layout: 'fit',
                    columnWidth: 0.5,
                    adding: '0 0 0 0', //(top, right, bottom, left)
                    items: [{
                        xtype: 'fieldset',
                        title: 'Aluno',
                        id: 'modprojetos_viewFieldsetAluno',
                        items: [{
                            layout: 'hbox',
                            border: false,
                            items: [{
                                xtype: 'cpffield',
                                itemId: 'modprojetos_cpfAluno',
                                fieldLabel: 'CPF',
                                name: 'aluno_cpf',
                                allowBlank: false,
                                labelWidth: 50,
                                width: 200,
                                padding: '0 10 0 0',// (top, right, bottom, left).
                                plugins: [{
                                    ptype: 'ux.textMask',
                                    mask: '999.999.999-99',
                                    clearWhenInvalid: false
                                }]
                            },{
                                xtype: 'button',
                                iconCls: 'icon-search-white',
                                itemId: 'btnBuscaAluno'
                            }]
                        },{
                            xtype: 'displayfield',
                            id: 'modprojetos_FormNomeAluno',
                            name: 'aluno',
                            fieldLabel: 'Nome',
                            submitValue: true,
                            allowBlank: false,
                            labelWidth: 50,
                        },{
                            xtype: 'displayfield',
                            id: 'modprojetos_FormEmailAluno',
                            name: 'aluno_email',
                            fieldLabel: 'E-mail',
                            submitValue: true,
                            allowBlank: false,
                            labelWidth: 50,
                        },{
                            xtype: 'displayfield',
                            id: 'modprojetos_FormCursoAluno',
                            name: 'descricao_curso',
                            fieldLabel: 'Curso',
                            allowBlank: true,
                            labelWidth: 50,
                        }]
                    }]
                }]
            },{
                xtype: 'panel',
                header: false,
                border: false,
                title: 'Informações do projeto',
                width: 780,
                flex: 6,
                layout: 'anchor',
                adding: '0 3 0 3', //(top, right, bottom, left)
                items: [{
                    xtype: 'fieldset',
                    title: 'Informações do projeto',
                    items: [{
                        xtype: 'hiddenfield',
                        name: 'id',
                        submitValue: true
                    },{
                        xtype: 'textareafield',
                        fieldLabel: 'Título',
                        allowBlank: false,
                        grow: true,
                        name: 'titulo',
						labelAlign: 'top',
                        labelWidth: 40,
                        anchor: '100%'
                    },{
                        layout: 'hbox',
                        border: false,
                        padding: '3 0 3 0', //(top, right, bottom, left)
                        items: [
						{	xtype: 'combobox',
							fieldLabel: 'Instituição',
							name: 'fgk_instituicao',
							labelAlign: 'top',
							queryMode: 'local',
							allowBlank: false,
							width: 165,
							editable: true,
							store: new Ext.data.JsonStore({
								proxy: {
									type: 'ajax',
									url: 'Server/projetos/storeComboInstituicao.php',
									reader: {
										type: 'json',
										root: 'resultado'
									}
								},
								fields: [
									{name:'id',	type: 'int'},
									{name:'sigla', type:'string'}
								]
							}),
							valueField: 'id',
							displayField: 'sigla',
							triggerAction: 'all',
							forceSelection:true,
							listeners: {
								render: function(){
									this.getStore().load();
								}
							}
						},
						{   xtype: 'combobox',
                            id: 'modprojetos_viewComboArea',
                            name: 'fgk_area',
                            allowBlank: false,
                            fieldLabel: 'Área',
                            labelAlign: 'top',
                            store: 'Projetos.Area',
                            queryMode: 'remote',
                            queryParam: 'filtro',
                            displayField: 'codigo_area',
                            valueField: 'id_area',
                            labelWidth: 60,
                            width: 150,
							padding: '0 0 0 3' //(top, right, bottom, left)
                        },
						{   xtype: 'combobox',
                            id: 'modprojetos_viewComboAreaSpec',
                            name: 'fgk_area_especifica',
                            allowBlank: false,
                            fieldLabel: 'Área específica',
                            labelAlign: 'top',
                            store: 'Projetos.AreaSpec',
                            queryMode: 'remote',
                            queryParam: 'filtro',
                            displayField: 'descricao_area_especifica',
                            valueField: 'id',
                            labelWidth: 35,
                            width: 250,
                            disabled: true,
                            padding: '0 0 0 3' //(top, right, bottom, left)
                        },{
                            xtype: 'combobox',
                            id: 'modprojetos_viewComboDepartamento',
                            name: 'fgk_departamento',
                            allowBlank: false,
                            fieldLabel: 'Departamento',
                            labelAlign: 'top',
                            store: 'Projetos.Departamento',
                            queryMode: 'remote',
                            queryParam: 'filtro',
                            displayField: 'id_departamento',
                            valueField: 'id_departamento',
                            labelWidth: 90,
                            padding: '0 0 0 3' //(top, right, bottom, left)
                        }]
                    },{
                        layout: 'hbox',
                        border: false,
                        padding: '3 0 3 0', //(top, right, bottom, left)
                        items: [{
                            xtype: 'combobox',
                            id: 'modprojetos_viewComboPrograma_ic',
                            name: 'fgk_programa_ic',
                            allowBlank: false,
                            fieldLabel: 'Programa',
                            labelAlign: 'top',
                            store: 'Projetos.Programa_ic',
                            queryMode: 'remote',
                            queryParam: 'filtro',
                            displayField: 'nome',
                            valueField: 'id',
                            labelWidth: 60,
                            width: 200
                        },{
                            xtype: 'combobox',
                            id: 'modprojetos_viewComboOrgao',
                            name: 'fgk_orgao_fomento',
                            allowBlank: false,
                            fieldLabel: 'Orgao fomento',
                            store: 'Projetos.Orgao',
                            queryMode: 'remote',
                            queryParam: 'filtro',
                            displayField: 'sigla',
                            valueField: 'id',
                            labelWidth: 95,
                            labelAlign: 'top',
                            padding: '0 0 0 3' //(top, right, bottom, left)
                        },{
                            xtype: 'combobox',
                            id: 'modprojetos_viewComboCategoria',
                            name: 'fgk_categoria',
                            allowBlank: false,
                            fieldLabel: 'Categoria',
                            store: 'Projetos.Categoria',
                            queryMode: 'remote',
                            queryParam: 'filtro',
                            displayField: 'sigla_categoria',
                            valueField: 'id_categoria',
                            labelWidth: 95,
                            labelAlign: 'top',
                            padding: '0 0 0 3' //(top, right, bottom, left)
                        },{
                            xtype: 'checkbox',
                            name: 'apresentacao_obrigatoria',
                            allowBlank: false,
                            fieldLabel: 'Apresentação obrigatória',
                            boxLabel: 'Sim',
                            labelAlign: 'top',
                            inputValue: '1',
                            uncheckedValue: '0',
                            checked: true,
                            labelWidth: 150,
                            padding: '0 0 0 3' //(top, right, bottom, left)
                        }]
                    }]
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
            text: 'Salvar',
            id: 'modprojetos_btnCancelSalvaProjeto',
            iconCls: 'icon-save',
            width: 100
        },{
            text: 'Cancelar',
            itemId: 'modprojetos_btnCancelViewProjeto',
            iconCls: 'icon-cancel',
            width: 100
        }]
    }]
});