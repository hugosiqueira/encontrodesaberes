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
 * A Surface is an interface to render methods inside {@link Ext.draw.Component}.
 *
 * Most of the Surface methods are abstract and they have a concrete implementation
 * in {@link Ext.draw.engine.Vml VML} or {@link Ext.draw.engine.Svg SVG} engines.
 *
 * A Surface contains methods to render {@link Ext.draw.Sprite sprites}, get bounding
 * boxes of sprites, add sprites to the canvas, initialize other graphic components, etc.
 *
 * ## Adding sprites to surface
 *
 * One of the most used methods for this class is the {@link #add} method, to add Sprites to
 * the surface. For example:
 *
 *     drawComponent.surface.add({
 *         type: 'circle',
 *         fill: '#ffc',
 *         radius: 100,
 *         x: 100,
 *         y: 100
 *     });
 *
 * The configuration object passed in the `add` method is the same as described in the
 * {@link Ext.draw.Sprite} class documentation.
 *
 * Sprites can also be added to surface by setting their surface config at creation time:
 *
 *     var sprite = Ext.create('Ext.draw.Sprite', {
 *         type: 'circle',
 *         fill: '#ff0',
 *         surface: drawComponent.surface,
 *         radius: 5
 *     });
 *
 * In order to properly apply properties and render the sprite we have to
 * `show` the sprite setting the option `redraw` to `true`:
 *
 *     sprite.show(true);
 *
 */
Ext.define('Ext.draw.Surface', {

    /* Begin Definitions */

    mixins: {
        observable: 'Ext.util.Observable'
    },

    requires: ['Ext.draw.CompositeSprite'],
    uses: ['Ext.draw.engine.Svg', 'Ext.draw.engine.Vml', 'Ext.draw.engine.SvgExporter', 'Ext.draw.engine.ImageExporter'],

    separatorRe: /[, ]+/,
    
    enginePriority: ['Svg', 'Vml'],

    statics: {
        /**
         * Creates and returns a new concrete Surface instance appropriate for the current environment.
         * @param {Object} config Initial configuration for the Surface instance
         * @param {String[]} enginePriority (Optional) order of implementations to use; the first one that is
         * available in the current environment will be used. Defaults to `['Svg', 'Vml']`.
         * @return {Object} The created Surface or false.
         * @static
         */
        create: function(config, enginePriority) {
            enginePriority = enginePriority || this.prototype.enginePriority;

            var i = 0,
                len = enginePriority.length;

            for (; i < len; i++) {
                if (Ext.supports[enginePriority[i]]) {
                    return Ext.create('Ext.draw.engine.' + enginePriority[i], config);
                }
            }
            return false;
        },
        
        /**
         * Exports a {@link Ext.draw.Surface surface} in a different format.
         * The surface may be exported to an SVG string, using the
         * {@link Ext.draw.engine.SvgExporter}. It may also be exported
         * as an image using the {@link Ext.draw.engine.ImageExporter ImageExporter}.
         * Note that this requires sending data to a remote server to process
         * the SVG into an image, see the {@link Ext.draw.engine.ImageExporter} for
         * more details.
         * @param {Ext.draw.Surface} surface The surface to export.
         * @param {Object} [config] The configuration to be passed to the exporter.
         * See the export method for the appropriate exporter for the relevant
         * configuration options
         * @return {Object} See the return types for the appropriate exporter
         * @static
         */
        save: function(surface, config) {
            config = config || {};
            var exportTypes = {
                    'image/png': 'Image',
                    'image/jpeg': 'Image',
                    'image/svg+xml': 'Svg'
                },
                prefix = exportTypes[config.type] || 'Svg',
                exporter = Ext.draw.engine[prefix + 'Exporter'];           

            return exporter.generate(surface, config);
            
        }
    },

    /* End Definitions */

    // @private
    availableAttrs: {
        blur: 0,
        "clip-rect": "0 0 1e9 1e9",
        cursor: "default",
        cx: 0,
        cy: 0,
        'dominant-baseline': 'auto',
        fill: "none",
        "fill-opacity": 1,
        font: '10px "Arial"',
        "font-family": '"Arial"',
        "font-size": "10",
        "font-style": "normal",
        "font-weight": 400,
        gradient: "",
        height: 0,
        hidden: false,
        href: "http://sencha.com/",
        opacity: 1,
        path: "M0,0",
        radius: 0,
        rx: 0,
        ry: 0,
        scale: "1 1",
        src: "",
        stroke: "none",
        "stroke-dasharray": "",
        "stroke-linecap": "butt",
        "stroke-linejoin": "butt",
        "stroke-miterlimit": 0,
        "stroke-opacity": 1,
        "stroke-width": 1,
        target: "_blank",
        text: "",
        "text-anchor": "middle",
        title: "Ext Draw",
        width: 0,
        x: 0,
        y: 0,
        zIndex: 0
    },

    /**
     * @cfg {Number} height
     * The height of this component in pixels (defaults to auto).
     */
    /**
     * @cfg {Number} width
     * The width of this component in pixels (defaults to auto).
     */

    container: undefined,
    height: 352,
    width: 512,
    x: 0,
    y: 0,

    /**
     * @cfg {Ext.draw.Sprite[]} items
     * Array of sprites or sprite config objects to add initially to the surface.
     */

    /**
     * @private Flag indicating that the surface implementation requires sprites to be maintained
     * in order of their zIndex. Impls that don't require this can set it to false.
     */
    orderSpritesByZIndex: true,


    /**
     * Creates new Surface.
     * @param {Object} config (optional) Config object.
     */
    constructor: function(config) {
        var me = this;
        config = config || {};
        Ext.apply(me, config);

        me.domRef = Ext.getDoc().dom;

        me.customAttributes = {};

        me.addEvents(
            /**
             * @event
             * Fires when a mousedown is detected within the surface.
             * @param {Ext.EventObject} e An object encapsulating the DOM event.
             */
            'mousedown',
            /**
             * @event
             * Fires when a mouseup is detected within the surface.
             * @param {Ext.EventObject} e An object encapsulating the DOM event.
             */
            'mouseup',
            /**
             * @event
             * Fires when a mouseover is detected within the surface.
             * @param {Ext.EventObject} e An object encapsulating the DOM event.
             */
            'mouseover',
            /**
             * @event
             * Fires when a mouseout is detected within the surface.
             * @param {Ext.EventObject} e An object encapsulating the DOM event.
             */
            'mouseout',
            /**
             * @event
             * Fires when a mousemove is detected within the surface.
             * @param {Ext.EventObject} e An object encapsulating the DOM event.
             */
            'mousemove',
            /**
             * @event
             * Fires when a mouseenter is detected within the surface.
             * @param {Ext.EventObject} e An object encapsulating the DOM event.
             */
            'mouseenter',
            /**
             * @event
             * Fires when a mouseleave is detected within the surface.
             * @param {Ext.EventObject} e An object encapsulating the DOM event.
             */
            'mouseleave',
            /**
             * @event
             * Fires when a click is detected within the surface.
             * @param {Ext.EventObject} e An object encapsulating the DOM event.
             */
            'click',
            /**
             * @event
             * Fires when a dblclick is detected within the surface.
             * @param {Ext.EventObject} e An object encapsulating the DOM event.
             */
            'dblclick'
        );

        me.mixins.observable.constructor.call(me);

        me.getId();
        me.initGradients();
        me.initItems();
        if (me.renderTo) {
            me.render(me.renderTo);
            delete me.renderTo;
        }
        me.initBackground(config.background);
    },

    // @private called to initialize components in the surface
    // this is dependent on the underlying implementation.
    initSurface: Ext.emptyFn,

    // @private called to setup the surface to render an item
    //this is dependent on the underlying implementation.
    renderItem: Ext.emptyFn,

    // @private
    renderItems: Ext.emptyFn,

    // @private
    setViewBox: function (x, y, width, height) {
        if (isFinite(x) && isFinite(y) && isFinite(width) && isFinite(height)) {
            this.viewBox = {x: x, y: y, width: width, height: height};
            this.applyViewBox();
        }
    },

    /**
     * Adds one or more CSS classes to the element. Duplicate classes are automatically filtered out.
     *
     * For example:
     *
     *     drawComponent.surface.addCls(sprite, 'x-visible');
     *
     * @param {Object} sprite The sprite to add the class to.
     * @param {String/String[]} className The CSS class to add, or an array of classes
     * @method
     */
    addCls: Ext.emptyFn,

    /**
     * Removes one or more CSS classes from the element.
     *
     * For example:
     *
     *     drawComponent.surface.removeCls(sprite, 'x-visible');
     *
     * @param {Object} sprite The sprite to remove the class from.
     * @param {String/String[]} className The CSS class to remove, or an array of classes
     * @method
     */
    removeCls: Ext.emptyFn,

    /**
     * Sets CSS style attributes to an element.
     *
     * For example:
     *
     *     drawComponent.surface.setStyle(sprite, {
     *         'cursor': 'pointer'
     *     });
     *
     * @param {Object} sprite The sprite to add, or an array of classes to
     * @param {Object} styles An Object with CSS styles.
     * @method
     */
    setStyle: Ext.emptyFn,

    // @private
    initGradients: function() {
        if (this.hasOwnProperty('gradients')) {
            var gradients = this.gradients,
                fn = this.addGradient,
                g, gLen;

            if (gradients) {
                for (g = 0, gLen = gradients.length; g < gLen; g++) {
                    if (fn.call(this, gradients[g], g, gLen) === false) {
                        break;
                    }
                }
            }
        }
    },

    // @private
    initItems: function() {
        var items = this.items;
        this.items = new Ext.draw.CompositeSprite();
        this.items.autoDestroy = true;
        this.groups = new Ext.draw.CompositeSprite();
        if (items) {
            this.add(items);
        }
    },

    // @private
    initBackground: function(config) {
        var me = this,
            width = me.width,
            height = me.height,
            gradientId, gradient;
        if (Ext.isString(config)) {
            config = {
                fill : config
            };
        }
        if (config) {
            if (config.gradient) {
                gradient = config.gradient;
                gradientId = gradient.id;
                me.addGradient(gradient);
                me.background = me.add({
                    type: 'rect',
                    x: 0,
                    y: 0,
                    width: width,
                    height: height,
                    fill: 'url(#' + gradientId + ')',
                    zIndex: -1
                });
            } else if (config.fill) {
                me.background = me.add({
                    type: 'rect',
                    x: 0,
                    y: 0,
                    width: width,
                    height: height,
                    fill: config.fill,
                    zIndex: -1
                });
            } else if (config.image) {
                me.background = me.add({
                    type: 'image',
                    x: 0,
                    y: 0,
                    width: width,
                    height: height,
                    src: config.image,
                    zIndex: -1
                });
            }
            // prevent me.background to jeopardize me.items.getBBox
            me.background.bboxExcluded = true;
        }
    },

    /**
     * Sets the size of the surface. Accomodates the background (if any) to fit the new size too.
     *
     * For example:
     *
     *     drawComponent.surface.setSize(500, 500);
     *
     * This method is generally called when also setting the size of the draw Component.
     *
     * @param {Number} w The new width of the canvas.
     * @param {Number} h The new height of the canvas.
     */
    setSize: function(w, h) {
        this.applyViewBox();
    },

    // @private
    scrubAttrs: function(sprite) {
        var i,
            attrs = {},
            exclude = {},
            sattr = sprite.attr;
        for (i in sattr) {
            // Narrow down attributes to the main set
            if (this.translateAttrs.hasOwnProperty(i)) {
                // Translated attr
                attrs[this.translateAttrs[i]] = sattr[i];
                exclude[this.translateAttrs[i]] = true;
            }
            else if (this.availableAttrs.hasOwnProperty(i) && !exclude[i]) {
                // Passtrhough attr
                attrs[i] = sattr[i];
            }
        }
        return attrs;
    },

    // @private
    onClick: function(e) {
        this.processEvent('click', e);
    },
    
    // @private
    onDblClick: function(e) {
        this.processEvent('dblclick', e);
    },

    // @private
    onMouseUp: function(e) {
        this.processEvent('mouseup', e);
    },

    // @private
    onMouseDown: function(e) {
        this.processEvent('mousedown', e);
    },

    // @private
    onMouseOver: function(e) {
        this.processEvent('mouseover', e);
    },

    // @private
    onMouseOut: function(e) {
        this.processEvent('mouseout', e);
    },

    // @private
    onMouseMove: function(e) {
        this.fireEvent('mousemove', e);
    },

    // @private
    onMouseEnter: Ext.emptyFn,

    // @private
    onMouseLeave: Ext.emptyFn,

    /**
     * Adds a gradient definition to the Surface. Note that in some surface engines, adding
     * a gradient via this method will not take effect if the surface has already been rendered.
     * Therefore, it is preferred to pass the gradients as an item to the surface config, rather
     * than calling this method, especially if the surface is rendered immediately (e.g. due to
     * 'renderTo' in its config). For more information on how to create gradients in the Chart
     * configuration object please refer to {@link Ext.chart.Chart}.
     *
     * The gradient object to be passed into this method is composed by:
     *
     * - **id** - string - The unique name of the gradient.
     * - **angle** - number, optional - The angle of the gradient in degrees.
     * - **stops** - object - An object with numbers as keys (from 0 to 100) and style objects as values.
     *
     * For example:
     *
     *    drawComponent.surface.addGradient({
     *        id: 'gradientId',
     *        angle: 45,
     *        stops: {
     *            0: {
     *                color: '#555'
     *            },
     *            100: {
     *                color: '#ddd'
     *            }
     *        }
     *    });
     *
     * @param {Object} gradient A gradient config.
     * @method
     */
    addGradient: Ext.emptyFn,

    /**
     * Adds a Sprite to the surface. See {@link Ext.draw.Sprite} for the configuration object to be
     * passed into this method.
     *
     * For example:
     *
     *     drawComponent.surface.add({
     *         type: 'circle',
     *         fill: '#ffc',
     *         radius: 100,
     *         x: 100,
     *         y: 100
     *     });
     *
     * @param {Ext.draw.Sprite[]/Ext.draw.Sprite...} args One or more Sprite objects or configs.
     * @return {Ext.draw.Sprite[]/Ext.draw.Sprite} The sprites added.
     */
    add: function() {
        var args = Array.prototype.slice.call(arguments),
            sprite,
            hasMultipleArgs = args.length > 1,
            items,
            results,
            i,
            ln,
            item;
            
        if (hasMultipleArgs || Ext.isArray(args[0])) {
            items = hasMultipleArgs ? args : args[0];
            results = [];

            for (i = 0, ln = items.length; i < ln; i++) {
                item = items[i];
                item = this.add(item);
                results.push(item);
            }

            return results;
        }
        sprite = this.prepareItems(args[0], true)[0];
        this.insertByZIndex(sprite);
        this.onAdd(sprite);
        return sprite;
    },

    /**
     * @private
     * Inserts a given sprite into the correct position in the items collection, according to
     * its zIndex. It will be inserted at the end of an existing series of sprites with the same or
     * lower zIndex. By ensuring sprites are always ordered, this allows surface subclasses to render
     * the sprites in the correct order for proper z-index stacking.
     * @param {Ext.draw.Sprite} sprite
     * @return {Number} the sprite's new index in the list
     */
    insertByZIndex: function(sprite) {
        var me = this,
            sprites = me.items.items,
            len = sprites.length,
            ceil = Math.ceil,
            zIndex = sprite.attr.zIndex,
            idx = len,
            high = idx - 1,
            low = 0,
            otherZIndex;

        if (me.orderSpritesByZIndex && len && zIndex < sprites[high].attr.zIndex) {
            // Find the target index via a binary search for speed
            while (low <= high) {
                idx = ceil((low + high) / 2);
                otherZIndex = sprites[idx].attr.zIndex;
                if (otherZIndex > zIndex) {
                    high = idx - 1;
                }
                else if (otherZIndex < zIndex) {
                    low = idx + 1;
                }
                else {
                    break;
                }
            }
            // Step forward to the end of a sequence of the same or lower z-index
            while (idx < len && sprites[idx].attr.zIndex <= zIndex) {
                idx++;
            }
        }

        me.items.insert(idx, sprite);
        return idx;
    },

    onAdd: function(sprite) {
        var group = sprite.group,
            draggable = sprite.draggable,
            groups, ln, i;
        if (group) {
            groups = [].concat(group);
            ln = groups.length;
            for (i = 0; i < ln; i++) {
                group = groups[i];
                this.getGroup(group).add(sprite);
            }
            delete sprite.group;
        }
        if (draggable) {
            sprite.initDraggable();
        }
    },

    /**
     * Removes a given sprite from the surface, optionally destroying the sprite in the process.
     * You can also call the sprite own `remove` method.
     *
     * For example:
     *
     *     drawComponent.surface.remove(sprite);
     *     //or...
     *     sprite.remove();
     *
     * @param {Ext.draw.Sprite} sprite
     * @param {Boolean} destroySprite
     */
    remove: function(sprite, destroySprite) {
        if (sprite) {
            this.items.remove(sprite);

            var groups = [].concat(this.groups.items),
                gLen   = groups.length,
                g;

            for (g = 0; g < gLen; g++) {
                groups[g].remove(sprite);
            }

            sprite.onRemove();
            if (destroySprite === true) {
                sprite.destroy();
            }
        }
    },

    /**
     * Removes all sprites from the surface, optionally destroying the sprites in the process.
     *
     * For example:
     *
     *     drawComponent.surface.removeAll();
     *
     * @param {Boolean} destroySprites Whether to destroy all sprites when removing them.
     */
    removeAll: function(destroySprites) {
        var items = this.items.items,
            ln = items.length,
            i;
        for (i = ln - 1; i > -1; i--) {
            this.remove(items[i], destroySprites);
        }
    },

    onRemove: Ext.emptyFn,

    onDestroy: Ext.emptyFn,

    /**
     * @private Using the current viewBox property and the surface's width and height, calculate the
     * appropriate viewBoxShift that will be applied as a persistent transform to all sprites.
     */
    applyViewBox: function() {
        var me = this,
            viewBox = me.viewBox,
            width = me.width || 1, // Avoid problems in division
            height = me.height || 1,
            viewBoxX, viewBoxY, viewBoxWidth, viewBoxHeight,
            relativeHeight, relativeWidth, size;

        if (viewBox && (width || height)) {
            viewBoxX = viewBox.x;
            viewBoxY = viewBox.y;
            viewBoxWidth = viewBox.width;
            viewBoxHeight = viewBox.height;
            relativeHeight = height / viewBoxHeight;
            relativeWidth = width / viewBoxWidth;
            size = Math.min(relativeWidth, relativeHeight);

            if (viewBoxWidth * size < width) {
                viewBoxX -= (width - viewBoxWidth * size) / 2 / size;
            }
            if (viewBoxHeight * size < height) {
                viewBoxY -= (height - viewBoxHeight * size) / 2 / size;
            }

            me.viewBoxShift = {
                dx: -viewBoxX,
                dy: -viewBoxY,
                scale: size
            };
            
            if (me.background) {
                me.background.setAttributes(Ext.apply({}, {
                    x: viewBoxX,
                    y: viewBoxY,
                    width: width / size,
                    height: height / size
                }, { hidden: false }), true);
            }
        } else {
            if (me.background && width && height) {
                me.background.setAttributes(Ext.apply({x: 0, y: 0, width: width, height: height}, { hidden: false }), true);
            }
        }
    },


    getBBox: function (sprite, isWithoutTransform) {
        var realPath = this["getPath" + sprite.type](sprite);
        if (isWithoutTransform) {
            sprite.bbox.plain = sprite.bbox.plain || Ext.draw.Draw.pathDimensions(realPath);
            return sprite.bbox.plain;
        }
        if (sprite.dirtyTransform) {
            this.applyTransformations(sprite, true);
        }
        sprite.bbox.transform = sprite.bbox.transform || Ext.draw.Draw.pathDimensions(Ext.draw.Draw.mapPath(realPath, sprite.matrix));
        return sprite.bbox.transform;
    },
    
    transformToViewBox: function (x, y) {
        if (this.viewBoxShift) {
            var me = this, shift = me.viewBoxShift;
            return [x / shift.scale - shift.dx, y / shift.scale - shift.dy];
        } else {
            return [x, y];
        }
    },

    // @private
    applyTransformations: function(sprite, onlyMatrix) {
        if (sprite.type == 'text') {
            // TODO: getTextBBox function always take matrix into account no matter whether `isWithoutTransform` is true. Fix that.
            sprite.bbox.transform = 0;
            this.transform(sprite, false);
        }


        sprite.dirtyTransform = false;
        
        var me = this,
            attr = sprite.attr;

        if (attr.translation.x != null || attr.translation.y != null) {
            me.translate(sprite);
        }
        if (attr.scaling.x != null || attr.scaling.y != null) {
            me.scale(sprite);
        }
        if (attr.rotation.degrees != null) {
            me.rotate(sprite);
        }
        
        sprite.bbox.transform = 0;
        this.transform(sprite, onlyMatrix);
        sprite.transformations = [];
    },

    // @private
    rotate: function (sprite) {
        var bbox,
            deg = sprite.attr.rotation.degrees,
            centerX = sprite.attr.rotation.x,
            centerY = sprite.attr.rotation.y;
        if (!Ext.isNumber(centerX) || !Ext.isNumber(centerY)) {
            bbox = this.getBBox(sprite, true);
            centerX = !Ext.isNumber(centerX) ? bbox.x + bbox.width / 2 : centerX;
            centerY = !Ext.isNumber(centerY) ? bbox.y + bbox.height / 2 : centerY;
        }
        sprite.transformations.push({
            type: "rotate",
            degrees: deg,
            x: centerX,
            y: centerY
        });
    },

    // @private
    translate: function(sprite) {
        var x = sprite.attr.translation.x || 0,
            y = sprite.attr.translation.y || 0;
        sprite.transformations.push({
            type: "translate",
            x: x,
            y: y
        });
    },

    // @private
    scale: function(sprite) {
        var bbox,
            x = sprite.attr.scaling.x || 1,
            y = sprite.attr.scaling.y || 1,
            centerX = sprite.attr.scaling.centerX,
            centerY = sprite.attr.scaling.centerY;

        if (!Ext.isNumber(centerX) || !Ext.isNumber(centerY)) {
            bbox = this.getBBox(sprite, true);
            centerX = !Ext.isNumber(centerX) ? bbox.x + bbox.width / 2 : centerX;
            centerY = !Ext.isNumber(centerY) ? bbox.y + bbox.height / 2 : centerY;
        }
        sprite.transformations.push({
            type: "scale",
            x: x,
            y: y,
            centerX: centerX,
            centerY: centerY
        });
    },

    // @private
    rectPath: function (x, y, w, h, r) {
        if (r) {
            return [["M", x + r, y], ["l", w - r * 2, 0], ["a", r, r, 0, 0, 1, r, r], ["l", 0, h - r * 2], ["a", r, r, 0, 0, 1, -r, r], ["l", r * 2 - w, 0], ["a", r, r, 0, 0, 1, -r, -r], ["l", 0, r * 2 - h], ["a", r, r, 0, 0, 1, r, -r], ["z"]];
        }
        return [["M", x, y], ["l", w, 0], ["l", 0, h], ["l", -w, 0], ["z"]];
    },

    // @private
    ellipsePath: function (x, y, rx, ry) {
        if (ry == null) {
            ry = rx;
        }
        return [["M", x, y], ["m", 0, -ry], ["a", rx, ry, 0, 1, 1, 0, 2 * ry], ["a", rx, ry, 0, 1, 1, 0, -2 * ry], ["z"]];
    },

    // @private
    getPathpath: function (el) {
        return el.attr.path;
    },

    // @private
    getPathcircle: function (el) {
        var a = el.attr;
        return this.ellipsePath(a.x, a.y, a.radius, a.radius);
    },

    // @private
    getPathellipse: function (el) {
        var a = el.attr;
        return this.ellipsePath(a.x, a.y,
                                a.radiusX || (a.width / 2) || 0,
                                a.radiusY || (a.height / 2) || 0);
    },

    // @private
    getPathrect: function (el) {
        var a = el.attr;
        return this.rectPath(a.x || 0, a.y || 0, a.width || 0, a.height || 0, a.r || 0);
    },

    // @private
    getPathimage: function (el) {
        var a = el.attr;
        return this.rectPath(a.x || 0, a.y || 0, a.width, a.height);
    },

    // @private
    getPathtext: function (el) {
        var bbox = this.getBBoxText(el);
        return this.rectPath(bbox.x, bbox.y, bbox.width, bbox.height);
    },

    createGroup: function(id) {
        var group = this.groups.get(id);
        if (!group) {
            group = new Ext.draw.CompositeSprite({
                surface: this
            });
            group.id = id || Ext.id(null, 'ext-surface-group-');
            this.groups.add(group);
        }
        return group;
    },

    /**
     * Returns a new group or an existent group associated with the current surface.
     * The group returned is a {@link Ext.draw.CompositeSprite} group.
     *
     * For example:
     *
     *     var spriteGroup = drawComponent.surface.getGroup('someGroupId');
     *
     * @param {String} id The unique identifier of the group.
     * @return {Object} The {@link Ext.draw.CompositeSprite}.
     */
    getGroup: function(id) {
        var group;
        if (typeof id == "string") {
            group = this.groups.get(id);
            if (!group) {
                group = this.createGroup(id);
            }
        } else {
            group = id;
        }
        return group;
    },

    // @private
    prepareItems: function(items, applyDefaults) {
        items = [].concat(items);
        // Make sure defaults are applied and item is initialized
        var item, i, ln;
        for (i = 0, ln = items.length; i < ln; i++) {
            item = items[i];
            if (!(item instanceof Ext.draw.Sprite)) {
                // Temporary, just take in configs...
                item.surface = this;
                items[i] = this.createItem(item);
            } else {
                item.surface = this;
            }
        }
        return items;
    },

    /**
     * Changes the text in the sprite element. The sprite must be a `text` sprite.
     * This method can also be called from {@link Ext.draw.Sprite}.
     *
     * For example:
     *
     *     var spriteGroup = drawComponent.surface.setText(sprite, 'my new text');
     *
     * @param {Object} sprite The Sprite to change the text.
     * @param {String} text The new text to be set.
     * @method
     */
    setText: Ext.emptyFn,

    // @private Creates an item and appends it to the surface. Called
    // as an internal method when calling `add`.
    createItem: Ext.emptyFn,

    /**
     * Retrieves the id of this component.
     * Will autogenerate an id if one has not already been set.
     */
    getId: function() {
        return this.id || (this.id = Ext.id(null, 'ext-surface-'));
    },

    /**
     * Destroys the surface. This is done by removing all components from it and
     * also removing its reference to a DOM element.
     *
     * For example:
     *
     *      drawComponent.surface.destroy();
     */
    destroy: function() {
        var me = this;
        delete me.domRef;
        if (me.background) {
            me.background.destroy();
        }
        me.removeAll(true);
        Ext.destroy(me.groups.items);
    }
});
