Ext.define('Seic.view.Projetos.mainProjetos', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.modprojetos_mainprojetos',
    id: 'modprojetos_mainprojetos',
    store: 'Projetos.Projetos',
    emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",

    plugins: [{
        ptype: 'rowexpander',
        expandOnDblClick: false,
        expandOnEnter: false,
        rowBodyTpl: ['<div><b>Título: </b>{titulo}</div>']
    }],

    columns: {
        defaults: {
            menuDisabled: true,
            resizable: false
        },

        items: [{
            header: 'id',
            dataIndex: 'id',
            hidden: true
        },{   
            header: 'Categoria',
            dataIndex: 'sigla_categoria',
            flex: 0.09
        },{   
            header: 'Orientador',
            dataIndex: 'orientador',
            flex: 0.3
        },{   
            header: 'Aluno',
            dataIndex: 'aluno',
            flex: 0.3
        },{   
            header: 'Área',
            dataIndex: 'codigo_area',
            flex: 0.08
        },{   
            header: 'Órgão fomento',
            dataIndex: 'sigla_orgao',
            flex: 0.14
        },{   
            header: 'Programa Ini. Científica',
            dataIndex: 'nome_programa_ic',
            flex: 0.19
        },{   
            header: 'Título',
            dataIndex: 'titulo',
            hidden: true
        },{   
            header: 'Trabalho',
            dataIndex: 'bool_trabalho',
            flex: 0.08,
            renderer: function(value, metaData, record, rowIndex, colIndex, store){
                if(value){
                    metaData.tdAttr = 'data-qtip="Contém trabalho relacionado."';
                    metaData.tdCls = 'trabalhos-minishortcut';
                }else{
                    metaData.tdAttr = 'data-qtip="Não contém trabalho relacionado."';
                    metaData.tdCls = 'icon-none';
                }
            }
        },{
            header: 'Obrig.',
            dataIndex: 'apresentacao_obrigatoria',
            flex: 0.05,
            renderer: function(value, metaData, record, rowIndex, colIndex, store){
                if(value){
                    metaData.tdAttr = 'data-qtip="Apresentação obrigatória."';
                    metaData.tdCls = 'icon-check';
                }else{
                    metaData.tdAttr = 'data-qtip="Apresentação não obrigatória."';
                    metaData.tdCls = 'icon-none';
                }
            }
    }]
    },

    dockedItems: [{
        xtype: 'toolbar',
        dock: 'top',
        items: [{
            text: 'Adicionar',
            itemId: 'modprojetos_btnAddProjeto',
            iconCls: 'icon-add',
            width: 100
        },{
            text: 'Editar',
            id: 'modprojetos_btnEditProjeto',
            iconCls: 'icon-edit',
            width: 100,
            disabled: true
        },{
            text: 'Apagar',
            id: 'modprojetos_btnDeletaProjeto',
            iconCls: 'icon-delete',
            width: 100,
            disabled: true
        },{
            text: 'Gerar trabalho',
            id: 'modprojetos_btnGerarTrabalho',
            iconCls: 'icon-novoTrabalho',
            disabled: true
        },'->',{
            text: 'Exportar',
            itemId: 'btnExport',
            iconCls: 'icon-excel'
        },{
            xtype: 'searchfield',
            store: 'Projetos.Projetos',
            emptyText: 'Busca rápida...',
            paramName: 'filtro',
            width: 250
        },{
            text: 'Busca avançada',
            id: 'modprojetos_btnBuscaAvancada',
            width: 110
        }]
    },{
        xtype: 'toolbar',
        id: 'modprojetos_barraBuscaAvancada',
        dock: 'top',
        hidden: true,
        style: {
            background: '#FF6666'
        }
    },{  
        xtype: 'pagingtoolbar',
        dock: 'bottom',
        store: 'Projetos.Projetos',
        displayInfo: true,
        displayMsg: 'Exibindo {0} - {1} de {2} projetos',
        emptyMsg: "Nenhum projeto encontrado."
    }]
});