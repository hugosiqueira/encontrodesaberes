/*
This file is part of Ext JS 4.2

Copyright (c) 2011-2013 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as
published by the Free Software Foundation and appearing in the file LICENSE included in the
packaging of this file.

Please review the following information to ensure the GNU General Public License version 3.0
requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department
at http://www.sencha.com/contact.

Build date: 2013-05-16 14:36:50 (f9be68accb407158ba2b1be2c226a6ce1f649314)
*/
/**
 * @author Ed Spencer
 * @class Ext.data.association.HasMany
 * 
 * <p>Represents a one-to-many relationship between two models. Usually created indirectly via a model definition:</p>
 * 
<pre><code>
Ext.define('Product', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',      type: 'int'},
        {name: 'user_id', type: 'int'},
        {name: 'name',    type: 'string'}
    ]
});

Ext.define('User', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',   type: 'int'},
        {name: 'name', type: 'string'}
    ],
    // we can use the hasMany shortcut on the model to create a hasMany association
    hasMany: {model: 'Product', name: 'products'}
});
</code></pre>
* 
 * <p>Above we created Product and User models, and linked them by saying that a User hasMany Products. This gives
 * us a new function on every User instance, in this case the function is called 'products' because that is the name
 * we specified in the association configuration above.</p>
 * 
 * <p>This new function returns a specialized {@link Ext.data.Store Store} which is automatically filtered to load
 * only Products for the given model instance:</p>
 * 
<pre><code>
//first, we load up a User with id of 1
var user = Ext.create('User', {id: 1, name: 'Ed'});

//the user.products function was created automatically by the association and returns a {@link Ext.data.Store Store}
//the created store is automatically scoped to the set of Products for the User with id of 1
var products = user.products();

//we still have all of the usual Store functions, for example it's easy to add a Product for this User
products.add({
    name: 'Another Product'
});

//saves the changes to the store - this automatically sets the new Product's user_id to 1 before saving
products.sync();
</code></pre>
 * 
 * <p>The new Store is only instantiated the first time you call products() to conserve memory and processing time,
 * though calling products() a second time returns the same store instance.</p>
 * 
 * <p><u>Custom filtering</u></p>
 * 
 * <p>The Store is automatically furnished with a filter - by default this filter tells the store to only return
 * records where the associated model's foreign key matches the owner model's primary key. For example, if a User
 * with ID = 100 hasMany Products, the filter loads only Products with user_id == 100.</p>
 * 
 * <p>Sometimes we want to filter by another field - for example in the case of a Twitter search application we may
 * have models for Search and Tweet:</p>
 * 
<pre><code>
Ext.define('Search', {
    extend: 'Ext.data.Model',
    fields: [
        'id', 'query'
    ],

    hasMany: {
        model: 'Tweet',
        name : 'tweets',
        filterProperty: 'query'
    }
});

Ext.define('Tweet', {
    extend: 'Ext.data.Model',
    fields: [
        'id', 'text', 'from_user'
    ]
});

//returns a Store filtered by the filterProperty
var store = new Search({query: 'Sencha Touch'}).tweets();
</code></pre>
 * 
 * <p>The tweets association above is filtered by the query property by setting the {@link #filterProperty}, and is
 * equivalent to this:</p>
 * 
<pre><code>
var store = Ext.create('Ext.data.Store', {
    model: 'Tweet',
    filters: [
        {
            property: 'query',
            value   : 'Sencha Touch'
        }
    ]
});
</code></pre>
 */
Ext.define('Ext.data.association.HasMany', {
    extend: 'Ext.data.association.Association',
    alternateClassName: 'Ext.data.HasManyAssociation',
    requires: ['Ext.util.Inflector'],

    alias: 'association.hasmany',

    /**
     * @cfg {String} foreignKey The name of the foreign key on the associated model that links it to the owner
     * model. Defaults to the lowercased name of the owner model plus "_id", e.g. an association with a where a
     * model called Group hasMany Users would create 'group_id' as the foreign key. When the remote store is loaded,
     * the store is automatically filtered so that only records with a matching foreign key are included in the 
     * resulting child store. This can be overridden by specifying the {@link #filterProperty}.
     * <pre><code>
Ext.define('Group', {
    extend: 'Ext.data.Model',
    fields: ['id', 'name'],
    hasMany: 'User'
});

Ext.define('User', {
    extend: 'Ext.data.Model',
    fields: ['id', 'name', 'group_id'], // refers to the id of the group that this user belongs to
    belongsTo: 'Group'
});
     * </code></pre>
     */
    
    /**
     * @cfg {String} name The name of the function to create on the owner model to retrieve the child store.
     * If not specified, the pluralized name of the child model is used.
     * <pre><code>
// This will create a users() method on any Group model instance
Ext.define('Group', {
    extend: 'Ext.data.Model',
    fields: ['id', 'name'],
    hasMany: 'User'
});
var group = new Group();
console.log(group.users());

// The method to retrieve the users will now be getUserList
Ext.define('Group', {
    extend: 'Ext.data.Model',
    fields: ['id', 'name'],
    hasMany: {model: 'User', name: 'getUserList'}
});
var group = new Group();
console.log(group.getUserList());
     * </code></pre>
     */
    
    /**
     * @cfg {Object} storeConfig Optional configuration object that will be passed to the generated Store. Defaults to 
     * undefined.
     */
    
    /**
     * @cfg {String} filterProperty Optionally overrides the default filter that is set up on the associated Store. If
     * this is not set, a filter is automatically created which filters the association based on the configured 
     * {@link #foreignKey}. See intro docs for more details. Defaults to undefined
     */
    
    /**
     * @cfg {Boolean} autoLoad True to automatically load the related store from a remote source when instantiated.
     * Defaults to <tt>false</tt>.
     */
    
    /**
     * @cfg {String} type The type configuration can be used when creating associations using a configuration object.
     * Use 'hasMany' to create a HasMany association
     * <pre><code>
associations: [{
    type: 'hasMany',
    model: 'User'
}]
     * </code></pre>
     */
    
    constructor: function(config) {
        var me = this,
            ownerProto,
            name;
            
        me.callParent(arguments);
        
        me.name = me.name || Ext.util.Inflector.pluralize(me.associatedName.toLowerCase());
        
        ownerProto = me.ownerModel.prototype;
        name = me.name;
        
        Ext.applyIf(me, {
            storeName : name + "Store",
            foreignKey: me.ownerName.toLowerCase() + "_id"
        });
        
        ownerProto[name] = me.createStore();
    },
    
    /**
     * @private
     * Creates a function that returns an Ext.data.Store which is configured to load a set of data filtered
     * by the owner model's primary key - e.g. in a hasMany association where Group hasMany Users, this function
     * returns a Store configured to return the filtered set of a single Group's Users.
     * @return {Function} The store-generating function
     */
    createStore: function() {
        var that            = this,
            associatedModel = that.associatedModel,
            storeName       = that.storeName,
            foreignKey      = that.foreignKey,
            primaryKey      = that.primaryKey,
            filterProperty  = that.filterProperty,
            autoLoad        = that.autoLoad,
            storeConfig     = that.storeConfig || {};
        
        return function() {
            var me = this,
                config, filter,
                modelDefaults = {};
                
            if (me[storeName] === undefined) {
                if (filterProperty) {
                    filter = {
                        property  : filterProperty,
                        value     : me.get(filterProperty),
                        exactMatch: true
                    };
                } else {
                    filter = {
                        property  : foreignKey,
                        value     : me.get(primaryKey),
                        exactMatch: true
                    };
                }
                
                modelDefaults[foreignKey] = me.get(primaryKey);
                
                config = Ext.apply({}, storeConfig, {
                    model        : associatedModel,
                    filters      : [filter],
                    remoteFilter : false,
                    modelDefaults: modelDefaults,
                    disableMetaChangeEvent: true
                });
                
                me[storeName] = Ext.data.AbstractStore.create(config);
                if (autoLoad) {
                    me[storeName].load();
                }
            }
            
            return me[storeName];
        };
    },
    
    /**
     * Read associated data
     * @private
     * @param {Ext.data.Model} record The record we're writing to
     * @param {Ext.data.reader.Reader} reader The reader for the associated model
     * @param {Object} associationData The raw associated data
     */
    read: function(record, reader, associationData){
        var store = record[this.name](),
            inverse,
            items, iLen, i;
    
        store.add(reader.read(associationData).records);
    
        //now that we've added the related records to the hasMany association, set the inverse belongsTo
        //association on each of them if it exists
        inverse = this.associatedModel.prototype.associations.findBy(function(assoc){
            return assoc.type === 'belongsTo' && assoc.associatedName === record.$className;
        });
    
        //if the inverse association was found, set it now on each record we've just created
        if (inverse) {
            items = store.data.items;
            iLen  = items.length;

            for (i = 0; i < iLen; i++) {
                items[i][inverse.instanceName] = record;
            }
        }
    }
});