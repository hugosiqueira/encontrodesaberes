/*
 * File: app.js
 *
 * This file was generated by Sencha Architect version 3.0.0.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 4.2.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 4.2.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true,
    paths: {
        'Ext.ux.desktop': './desktop'
    }
});


Ext.application({

    requires: [
        'Ext.Loader',
        'Seic.view.Desktop',
        'Ext.grid.column.Date',
        'Ext.grid.column.Action',
        'Seic.widgets.SessionMonitor',
		'Seic.view.module.Admin',
		'Seic.view.module.Inscritos',
        'Seic.view.module.Projetos',
        'Seic.view.module.Trabalhos',
        'Seic.view.module.TrabalhosSeinter',
        'Seic.view.module.Credenciamento',
        'Seic.view.module.Financeiro',
        'Seic.view.module.CadastrosUfop',
        'Seic.view.module.CadastroIC',
        'Seic.view.module.CadastroOrgaos',
        'Seic.view.module.CadastroInstituicoes',
        'Seic.view.module.Revisores',
        'Seic.view.module.MiniProp',
        'Seic.view.module.Emails',
        'Seic.view.module.Monitoria',
        'Seic.view.module.Certificados',
        'Seic.view.module.Presenca',
        'Seic.view.module.Posters',
        'Seic.view.module.Avaliacoes',
        'Seic.view.module.Anais'
	],
    controllers: [
        'Desktop',
		'Admin',
		'Inscritos',
        'Projetos',
		'Trabalhos',
		'TrabalhosSeinter',
        'Credenciamento',
        'Financeiro',
        'CadastrosUfop',
        'CadastroIC',
        'CadastroOrgaos',
        'CadastroInstituicoes',
        'Revisores',
		'MiniProp',
		'Emails',
		'Monitoria',
		'Certificados',
        'Presenca',
        'Posters',
        'Avaliacoes',
        'Anais'
    ],
    name: 'Seic',
    launch: function(){
        Seic.widgets.SessionMonitor.start();
    }
});