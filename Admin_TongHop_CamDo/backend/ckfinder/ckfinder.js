﻿/*
 Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see license.txt or http://cksource.com/ckfinder/license
 */

        (function() {
            var a = (function() {
                var h = {
                    jY: 'E03L22F',
                    _: {},
                    status: 'unloaded',
                    basePath: (function() {
                        var k = window.CKFINDER_BASEPATH || '';
                        if (!k) {
                            var l = document.getElementsByTagName('script');
                            for (var m = 0; m < l.length; m++) {
                                var n = l[m].src.match(/(^|.*[\\\/])CKFINDER(?:_basic)?(?:_v2)?(?:_source)?.js(?:\?.*)?$/i);
                                if (n) {
                                    k = n[1];
                                    break;
                                }
                            }
                        }
                        if (k.indexOf('://') == -1)
                            if (k.indexOf('/') === 0)
                                k = location.href.match(/^.*?:\/\/[^\/]*/)[0] + k;
                            else
                                k = location.href.match(/^[^\?]*\/(?:)/)[0] + k;
                        return k;
                    })(),
                    getUrl: function(k) {
                        if (k.indexOf('://') == -1 && k.indexOf('/') !== 0)
                            k = this.basePath + k;
                        if (this.jY && k.charAt(k.length - 1) != '/')
                            k += (k.indexOf('?') >= 0 ? '&' : '?') + 't=' + this.jY;
                        return k;
                    }
                }, i = window.CKFINDER_GETURL;
                if (i) {
                    var j = h.getUrl;
                    h.getUrl = function(k) {
                        return i.call(h, k) || j.call(h, k);
                    };
                }
                return h;
            })();

            function b(h) {
                return a.instances[h];
            }
            ;
            var c = {
                callback: 1,
                selectThumbnailActionFunction: 1,
                selectActionFunction: 1
            };
            a.jd = function() {
                var j = this;
                var h = {};
                for (var i in j) {
                    if (!j.hasOwnProperty(i))
                        continue;
                    if (typeof j[i] == 'function' && !c[i] || typeof j[i] == 'undefined')
                        continue;
                    h[i] = j[i];
                }
                if (j.callback)
                    h.callback = j.callback;
                return h;
            };
            a.lj = function(h) {
                var k = this;
                h = h || k.basePath;
                var i = '';
                if (!h || h.length === 0)
                    h = CKFinder.DEFAULT_basePath;
                if (h.substr(h.length - 1, 1) != '/')
                    h += '/';
                h += 'ckfinder.html';
                var j;
                if (k.hh) {
                    j = k.hh;
                    if (typeof j == 'function')
                        j = j.toString().match(/function ([^(]+)/)[1];
                    i += '?action=js&amp;func=' + j;
                }
                if (k.jx) {
                    i += i ? '&amp;' : '?';
                    i += 'data=' + encodeURIComponent(k.jx);
                }
                if (k.disableThumbnailSelection) {
                    i += i ? '&amp;' : '?';
                    i += 'dts=1';
                } else if (k.lH || k.hh) {
                    j = k.lH || k.hh;
                    if (typeof j == 'function')
                        j = j.toString().match(/function ([^(]+)/)[1];
                    i += i ? '&amp;' : '?';
                    i += 'thumbFunc=' + j;
                    if (k.nm)
                        i += '&amp;tdata=' + encodeURIComponent(k.nm);
                    else if (!k.lH && k.jx)
                        i += '&amp;tdata=' + encodeURIComponent(k.jx);
                }
                if (k.startupPath) {
                    i += i ? '&amp;' : '?';
                    i += 'start=' + encodeURIComponent(k.startupPath + (k.startupFolderExpanded ? ':1' : ':0'));
                }
                if (k.rememberLastFolder !== undefined && !k.rememberLastFolder) {
                    i += i ? '&amp;' : '?';
                    i += 'rlf=0';
                }
                if (k.id) {
                    i += i ? '&amp;' : '?';
                    i += 'id=' + encodeURIComponent(k.id);
                }
                if (k.skin) {
                    i += i ? '&amp;' : '?';
                    i += 'skin=' + encodeURIComponent(k.skin);
                }
                return h + i;
            };

            function d(h) {
                var k = this;
                k.id = h.name;
                var i = h.element.getDocument().getWindow().$,
                        j = a.oC.getWindow().$;
                k.inPopup = !!(i && i.opener);
                k.inIframe = !k.inPopup && i != j.top && i.frameElement.nodeName.toLowerCase() == 'iframe';
                k.inFrame = !k.inPopup && i != j.top && i.frameElement.nodeName.toLowerCase() == 'frame';
                k.inUrlPopup = !!(k.inPopup && j.opener);
            }
            ;

            function e(h, i, j) {
                i.on('appReady', function(k) {
                    k.removeListener();
                    h.document = i.document.$;
                    h.folders = i.folders;
                    h.files = i.ld['filesview.filesview'].data().files;
                    h.basketFiles = i.basketFiles;
                    h.resourceTypes = i.resourceTypes;
                    h.connector = i.connector;
                    h.lang = i.lang;
                    h.langCode = i.langCode;
                    h.config = i.config;
                    i.ld['foldertree.foldertree'].on('afterAddFolder', function(l) {
                        l.removeListener();
                        if (j)
                            j(h);
                    }, h);
                }, h, null, 999);
            }
            ;
            d.prototype = {
                _: {},
                addFileContextMenuOption: function(h, i, j) {
                    var k = b(this.id),
                            l = 'FileContextMenu_' + h.command;
                    k.bD(l, {
                        exec: function(m) {
                            var n = m.ld['filesview.filesview'].tools.dH();
                            i(m.cg, n);
                        }
                    });
                    h.command = l;
                    if (!h.group)
                        h.group = 'file1';
                    k.gp(l, h);
                    k.ld['filesview.filesview'].on('beforeContextMenu', function o(m) {
                        if (j) {
                            var n = j(this.tools.dH());
                            if (n)
                                m.data.bj[l] = n == -1 ? a.aY : a.aS;
                        } else
                            m.data.bj[l] = a.aS;
                    });
                },
                disableFileContextMenuOption: function(h, i) {
                    var j = b(this.id),
                            k = i ? 'FileContextMenu_' + h : h,
                            l = function n(m) {
                                delete m.data.bj[k];
                            };
                    j.ld['filesview.filesview'].on('beforeContextMenu', l);
                    return function() {
                        j.ld['filesview.filesview'].removeListener('beforeContextMenu', l);
                    };
                },
                addFolderContextMenuOption: function(h, i, j) {
                    var k = b(this.id),
                            l = 'FolderContextMenu_' + h.command;
                    k.bD(l, {
                        exec: function(m) {
                            i(m.cg, m.aV);
                        }
                    });
                    h.command = l;
                    if (!h.group)
                        h.group = 'folder1';
                    k.gp(l, h);
                    k.ld['foldertree.foldertree'].on('beforeContextMenu', function o(m) {
                        if (j) {
                            var n = j(this.app.aV);
                            if (n)
                                m.data.bj[l] = n == -1 ? a.aY : a.aS;
                        } else
                            m.data.bj[l] = a.aS;
                    });
                },
                disableFolderContextMenuOption: function(h, i) {
                    var j = b(this.id),
                            k = i ? 'FolderContextMenu_' + h : h,
                            l = function n(m) {
                                delete m.data.bj[k];
                            };
                    j.ld['foldertree.foldertree'].on('beforeContextMenu', l);
                    return function() {
                        j.ld['foldertree.foldertree'].removeListener('beforeContextMenu', l);
                    };
                },
                addFolderDropMenuOption: function(h, i, j) {
                    var k = b(this.id),
                            l = 'FolderDropMenu_' + h.command;
                    k.bD(l, {
                        exec: function(n) {
                            i(n.cg, n.cK.oa());
                        }
                    });
                    h.command = l;
                    var m = new a.iD(k, l, h);
                    k.ld['foldertree.foldertree'].on('beforeDropMenu', function o(n) {
                        if (j ? j.call(k.cg, n.data.folder) : 1)
                            n.data.iG[l] = m;
                    });
                },
                disableFolderDropMenuOption: function(h, i) {
                    var j = b(this.id),
                            k = i ? 'FolderDropMenu_' + h : h,
                            l = function n(m) {
                                delete m.data.iG[k];
                            };
                    j.ld['foldertree.foldertree'].on('beforeDropMenu', l);
                    return function() {
                        j.ld['foldertree.foldertree'].removeListener('beforeDropMenu', l);
                    };
                },
                getSelectedFile: function() {
                    return b(this.id).ld['filesview.filesview'].tools.dH();
                },
                getSelectedFiles: function() {
                    return b(this.id).ld['filesview.filesview'].tools.oO();
                },
                getSelectedFolder: function() {
                    return b(this.id).aV;
                },
                filterFiles: function(h) {
                    b(this.id).ld['filesview.filesview'].oW('requestRenderFiles', {
                        lookup: h
                    });
                },
                setUiColor: function(h) {
                    return b(this.id).setUiColor(h);
                },
                destroy: function(h) {
                    b(this.id).destroy();
                    h && h();
                },
                openDialog: function(h, i) {
                    var l = this;
                    var j = new a.dom.document(window.document).getHead(),
                            k = b(l.id).document.getWindow();
                    if (l.inFrame || l.inPopup || l.inIframe)
                        a.document = b(l.id).document;
                    return b(l.id).openDialog(h, i, j);
                },
                openMsgDialog: function(h, i) {
                    b(this.id).msgDialog(h, i);
                },
                openConfirmDialog: function(h, i, j) {
                    b(this.id).fe(h, i, j);
                },
                openInputDialog: function(h, i, j, k) {
                    b(this.id).hs(h, i, j, k);
                },
                openSkippedFilesDialog: function(h, i, j, k) {
                    b(this.id).skippedFilesDialog(h, i, j, k);
                },
                addTool: function(h) {
                    return b(this.id).plugins.tools.addTool(h);
                },
                addToolPanel: function(h) {
                    return b(this.id).plugins.tools.addToolPanel(h);
                },
                removeTool: function(h) {
                    b(this.id).plugins.tools.removeTool(h);
                },
                showTool: function(h) {
                    b(this.id).plugins.tools.showTool(h);
                },
                hideTool: function(h) {
                    b(this.id).plugins.tools.hideTool(h);
                },
                getResourceType: function(h) {
                    return b(this.id).getResourceType(h);
                },
                log: function(h) {
                    a.log.apply(a.log, arguments);
                },
                getLog: function() {
                    return a.mZ();
                },
                emptyBasket: function() {
                    b(this.id).execCommand('TruncateBasket');
                },
                replaceUploadForm: function(h, i, j, k) {
                    var l = b(this.id);
                    if (!k)
                        k = 10;
                    if (k >= (l.dC || 20))
                        return;
                    l.dC = k;
                    l.ld['formpanel.formpanel'].on('beforeUploadFileForm', function(m) {
                        if (m.data.step != 2)
                            return;
                        if (k > l.dC)
                            return;
                        m.cancel(true);
                        var n = this.data(),
                                o = m.data.folder;
                        try {
                            if (n.dc == 'upload')
                                this.oW('requestUnloadForm', function() {
                                    this.app.cS('upload').bR(a.aS);
                                });
                            else {
                                if (this.data().dc)
                                    this.oW('requestUnloadForm');
                                if (!j)
                                    this.eh.removeClass('show_border');
                                this.oW('requestLoadForm', {
                                    html: h,
                                    command: 'upload'
                                });
                                i && i();
                            }
                        } catch (p) {
                            this.oW('failedUploadFileForm', m.data);
                            this.oW('afterUploadFileForm', m.data);
                            throw a.ba(p);
                        }
                    });
                    return {
                        hide: function() {
                            l.oW('requestUnloadForm', function() {
                                l.cS('upload').bR(a.aS);
                            });
                        }
                    };
                },
                resizeFormPanel: function(h) {
                    var i = b(this.id);
                    if (typeof h == 'undefined') {
                        i.document.getById('panel_view').setStyle('height', '');
                        i.document.getById('panel_widget').setStyle('height', '');
                    } else {
                        var j = Math.min(h, Math.max(90, i.document.getById('main_container').$.offsetHeight - 300));
                        i.document.getById('panel_view').setStyle('height', j + 'px');
                        i.document.getById('panel_widget').setStyle('height', j - 3 + 'px');
                    }
                    i.layout.ea(true);
                },
                refreshOpenedFolder: function() {
                    var h = b(this.id),
                            i = h.ld['filesview.filesview'].tools.currentFolder();
                    h.oW('requestSelectFolder', {
                        folder: i
                    });
                },
                selectFile: function(h) {
                    var i = b(this.id);
                    i.oW('requestSelectFile', {
                        file: h,
                        scrollTo: 1
                    });
                },
                closePopup: function() {
                    if (!this.inPopup)
                        return;
                    b(this.id).element.getDocument().getWindow().$.close();
                },
                openFolder: function(h, i) {
                    var j = b(this.id);
                    i = i.replace(/\/$/, '');
                    h = h.toLowerCase();
                    for (var k = 0; k < j.folders.length; k++) {
                        var l = j.folders[k];
                        if (l.getPath().replace(/\/$/, '') == i && h == l.type.toLowerCase()) {
                            j.oW('requestSelectFolder', {
                                folder: l
                            });
                            j.oW('requestShowFolderFiles', {
                                folder: l
                            });
                            return;
                        }
                    }
                },
                setUiColor: function(h) {
                    b(this.id).setUiColor(h);
                },
                        execCommand: function(h) {
                            b(this.id).execCommand(h);
                        }
            };
            (function() {
                window.CKFinder = function(i, j) {
                    if (i)
                        for (var k in i) {
                            if (!i.hasOwnProperty(k))
                                continue;
                            if (typeof i[k] == 'function' && k != 'callback')
                                continue;
                            this[k] = i[k];
                        }
                    this.callback = j;
                };

                function h(i) {
                    var j = 1;
                    while (CKFinder._.instanceConfig[j])
                        j++;
                    CKFinder._.instanceConfig[j] = i;
                    return j;
                }
                ;
                CKFinder.prototype = {
                    create: function(i) {
                        var j = 'ckf' + Math.random().toString().substr(2, 9);
                        document.write('<span id="' + j + '"></span>');
                        i = a.tools.extend(a.jd.call(this), i, true);
                        var k = a.replace(j, i, CKFinder);
                        this.api = k.cg;
                        return k.cg;
                    },
                    appendTo: function(i, j) {
                        j = a.tools.extend(a.jd.call(this), j, true);
                        var k = a.appendTo(i, j, CKFinder);
                        this.api = k.cg;
                        return k.cg;
                    },
                    replace: function(i, j) {
                        j = a.tools.extend(a.jd.call(this), j, true);
                        var k = a.replace(i, j, CKFinder);
                        this.api = k.cg;
                        return k.cg;
                    },
                    popup: function(i, j) {
                        var s = this;
                        i = i || '80%';
                        j = j || '70%';
                        if (typeof i == 'string' && i.length > 1 && i.substr(i.length - 1, 1) == '%')
                            i = parseInt(window.screen.width * parseInt(i, 10) / 100, 10);
                        if (typeof j == 'string' && j.length > 1 && j.substr(j.length - 1, 1) == '%')
                            j = parseInt(window.screen.height * parseInt(j, 10) / 100, 10);
                        if (i < 200)
                            i = 200;
                        if (j < 200)
                            j = 200;
                        var k = parseInt((window.screen.height - j) / 2, 10),
                                l = parseInt((window.screen.width - i) / 2, 10),
                                m = 'location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,width=' + i + ',height=' + j + ',top=' + k + ',left=' + l,
                                n = a.env.webkit ? 'about:blank' : '',
                                o = window.open(n, 'CKFinderpopup', m, true);
                        if (!o)
                            return false;
                        s.width = s.height = '100%';
                        var p = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html><head><title>Hệ thống quản lý tập tin pubweb.vn</title><style type="text/css">body, html, iframe, #ckfinder { margin: 0; padding: 0; border: 0; width: 100%; height: 100%; overflow: hidden; }</style></head><body></body></html>',
                                q = new a.dom.document(o.document);
                        q.$.open();
                        if (a.env.isCustomDomain())
                            q.$.domain = window.document.domain;
                        q.$.write(p);
                        q.$.close();
                        try {
                            var r = navigator.userAgent.toLowerCase();
                            if (r.indexOf(' chrome/') == -1) {
                                o.moveTo(l, k);
                                o.resizeTo(i, j);
                            }
                            o.focus();
                            return s.appendTo(q.bH());
                        } catch (t) {
                            return s.appendTo(q.bH());
                        }
                        return false;
                    }
                };
                CKFinder._ = {};
                CKFinder._.instanceConfig = [];
                CKFinder.lang = {};
                CKFinder.version = '2.4.1';
                CKFinder.revision = '2679';
                CKFinder.addPlugin = function(i, j, k) {
                    var l = {
                        bM: k || []
                    };
                    if (typeof j == 'function')
                        j = {
                            appReady: j
                        };
                    for (var m in j) {
                        if (!j.hasOwnProperty(m))
                            continue;
                        if (m != 'connectorInitialized' && m != 'uiReady')
                            l[m] = j[m];
                    }
                    l.bz = function(n) {
                        if (n.config.readOnly && l.readOnly === false)
                            return null;
                        if (j.connectorInitialized)
                            n.on('connectorInitialized', function(o) {
                                var p = j.connectorInitialized;
                                if (p)
                                    p.call(p, n.cg, o.data.xml);
                            }, null, null, 1000);
                        if (j.connectorResponse)
                            n.on('connectorResponse', function(o) {
                                var p = j.connectorResponse;
                                if (p)
                                    p.call(p, n.cg, o.data.xml);
                            });
                        if (j.galleryCallback)
                            n.on('launchGallery', function(o) {
                                var p = j.galleryCallback;
                                if (p)
                                    o.data.bx = p.call(p, n.cg, o.data.selected, o.data.files);
                            });
                        if (j.uiReady)
                            n.on('uiReady', function() {
                                var o = j.uiReady;
                                o.call(o, n.cg);
                            }, null, null, 1000);
                        if (j.appReady)
                            n.on('appReady', function() {
                                var o = j.appReady;
                                o.call(o, n.cg);
                            }, null, null, 1000);
                    };
                    a.plugins.add(i, l);
                };
                CKFinder.getPluginPath = function(i) {
                    return a.plugins.getPath(i);
                };
                CKFinder.addExternalPlugin = function(i, j, k) {
                    a.plugins.tR(i, j, k);
                };
                CKFinder.setPluginLang = function(i, j, k) {
                    a.plugins.rX(i, j, k);
                };
                CKFinder.dialog = {
                    add: function(i, j) {
                        if (typeof j == 'function')
                            j = a.tools.override(j, function(k) {
                                return function(l) {
                                    return k(l.cg);
                                };
                            });
                        a.dialog.add(i, j);
                    }
                };
                CKFinder.tools = {};
                CKFinder.env = {};
                CKFinder.dom = {};
                CKFinder.create = function(i, j, k, l, m) {
                    var n;
                    if (i !== null && typeof i === 'object') {
                        n = new CKFinder();
                        for (var o in i)
                            n[o] = i[o];
                    } else {
                        n = new CKFinder();
                        n.basePath = i;
                        if (j)
                            n.width = j;
                        if (k)
                            n.height = j;
                        if (l)
                            n.selectActionFunction = l;
                        if (m)
                            n.callback = m;
                    }
                    return n.create();
                };
                CKFinder.popup = function(i, j, k, l, m) {
                    var n;
                    if (i !== null && typeof i === 'object') {
                        n = new CKFinder();
                        for (var o in i)
                            n[o] = i[o];
                    } else {
                        n = new CKFinder();
                        n.basePath = i;
                        if (l)
                            n.selectActionFunction = l;
                        if (m)
                            n.callback = m;
                    }
                    return n.popup(j, k);
                };
                CKFinder.setupFCKeditor = function(i, j, k, l) {
                    var m, n;
                    if (j !== null && typeof j === 'object') {
                        n = h(j);
                        m = new CKFinder();
                        for (var o in j) {
                            m[o] = j[o];
                            if (o == 'width') {
                                var p = m[o] || 800;
                                if (typeof p == 'string' && p.length > 1 && p.substr(p.length - 1, 1) == '%')
                                    p = parseInt(window.screen.width * parseInt(p, 10) / 100, 10);
                                i.Config.LinkBrowserWindowWidth = p;
                                i.Config.ImageBrowserWindowWidth = p;
                                i.Config.FlashBrowserWindowWidth = p;
                            } else if (o == 'height') {
                                var q = m[o] || 600;
                                if (typeof q == 'string' && q.length > 1 && q.substr(q.length - 1, 1) == '%')
                                    q = parseInt(window.screen.height * parseInt(q, 10) / 100, 10);
                                i.Config.LinkBrowserWindowHeight = q;
                                i.Config.ImageBrowserWindowHeight = q;
                                i.Config.FlashBrowserWindowHeight = q;
                            }
                        }
                    } else {
                        m = new CKFinder();
                        m.basePath = j;
                    }
                    var r = m.basePath;
                    if (r.substr(0, 1) != '/' && r.indexOf('://') == -1)
                        r = document.location.pathname.substring(0, document.location.pathname.lastIndexOf('/') + 1) + r;
                    r = a.lj.call(m, r);
                    var s = r.indexOf('?') !== -1 ? '&' : '?';
                    if (n) {
                        r += s + 'configId=' + n;
                        s = '&';
                    }
                    i.Config.LinkBrowserURL = r;
                    i.Config.ImageBrowserURL = r + s + 'type=' + (k || 'Images');
                    i.Config.FlashBrowserURL = r + s + 'type=' + (l || 'Flash');
                    var t = r.substring(0, 1 + r.lastIndexOf('/'));
                    i.Config.LinkUploadURL = t + 'core/connector/' + CKFinder.config.connectorLanguage + '/connector.' + CKFinder.config.connectorLanguage + '?command=QuickUpload&type=Files';
                    i.Config.ImageUploadURL = t + 'core/connector/' + CKFinder.config.connectorLanguage + '/connector.' + CKFinder.config.connectorLanguage + '?command=QuickUpload&type=' + (k || 'Images');
                    i.Config.FlashUploadURL = t + 'core/connector/' + CKFinder.config.connectorLanguage + '/connector.' + CKFinder.config.connectorLanguage + '?command=QuickUpload&type=' + (l || 'Flash');
                };
                CKFinder.setupCKEditor = function(i, j, k, l) {
                    if (i === null) {
                        for (var m in CKEDITOR.instances)
                            CKFinder.setupCKEditor(CKEDITOR.instances[m], j, k, l);
                        CKEDITOR.on('instanceCreated', function(v) {
                            CKFinder.setupCKEditor(v.editor, j, k, l);
                        });
                        return;
                    }
                    var n, o;
                    if (j !== null && typeof j === 'object') {
                        o = h(j);
                        n = new CKFinder();
                        for (var p in j) {
                            n[p] = j[p];
                            if (p == 'width') {
                                var q = n[p] || 800;
                                if (typeof q == 'string' && q.length > 1 && q.substr(q.length - 1, 1) == '%')
                                    q = parseInt(window.screen.width * parseInt(q, 10) / 100, 10);
                                i.config.filebrowserWindowWidth = q;
                            } else if (p == 'height') {
                                var r = n[p] || 600;
                                if (typeof r == 'string' && r.length > 1 && r.substr(r.length - 1, 1) == '%')
                                    r = parseInt(window.screen.height * parseInt(r, 10) / 100, 10);
                                i.config.filebrowserWindowHeight = r;
                            }
                        }
                    } else {
                        n = new CKFinder();
                        n.basePath = j;
                    }
                    var s = n.basePath;
                    if (s.substr(0, 1) != '/' && s.indexOf('://') == -1)
                        s = document.location.pathname.substring(0, document.location.pathname.lastIndexOf('/') + 1) + s;
                    s = a.lj.call(n, s);
                    var t = s.indexOf('?') !== -1 ? '&' : '?';
                    if (o) {
                        s += t + 'configId=' + o;
                        t = '&';
                    }
                    i.config.filebrowserBrowseUrl = s;
                    i.config.filebrowserImageBrowseUrl = s + t + 'type=' + (k || 'Images');
                    i.config.filebrowserFlashBrowseUrl = s + t + 'type=' + (l || 'Flash');
                    var u = s.substring(0, 1 + s.lastIndexOf('/'));
                    i.config.filebrowserUploadUrl = u + 'core/connector/' + CKFinder.config.connectorLanguage + '/connector.' + CKFinder.config.connectorLanguage + '?command=QuickUpload&type=Files';
                    i.config.filebrowserImageUploadUrl = u + 'core/connector/' + CKFinder.config.connectorLanguage + '/connector.' + CKFinder.config.connectorLanguage + '?command=QuickUpload&type=' + (k || 'Images');
                    i.config.filebrowserFlashUploadUrl = u + 'core/connector/' + CKFinder.config.connectorLanguage + '/connector.' + CKFinder.config.connectorLanguage + '?command=QuickUpload&type=' + (l || 'Flash');
                };
            })();
            if (!a.event) {
                a.event = function() {
                };
                a.event.du = function(h, i) {
                    var j = a.event.prototype;
                    for (var k in j) {
                        if (h[k] == undefined)
                            h[k] = j[k];
                    }
                };
                a.event.prototype = (function() {
                    var h = function(j) {
                        var k = j.kk && j.kk() || j._ || (j._ = {});
                        return k.cC || (k.cC = {});
                    }, i = function(j) {
                        this.name = j;
                        this.dF = [];
                    };
                    i.prototype = {
                        mi: function(j) {
                            for (var k = 0, l = this.dF; k < l.length; k++) {
                                if (l[k].fn == j)
                                    return k;
                            }
                            return -1;
                        }
                    };
                    return {
                        on: function(j, k, l, m, n) {
                            var o = h(this),
                                    p = o[j] || (o[j] = new i(j));
                            if (p.mi(k) < 0) {
                                var q = p.dF;
                                if (!l)
                                    l = this;
                                if (isNaN(n))
                                    n = 10;
                                var r = this,
                                        s = function(u, v, w, x) {
                                            var y = {
                                                name: j,
                                                jN: this,
                                                application: u,
                                                data: v,
                                                jO: m,
                                                stop: w,
                                                cancel: x,
                                                removeListener: function() {
                                                    r.removeListener(j, k);
                                                }
                                            };
                                            k.call(l, y);
                                            return y.data;
                                        };
                                s.fn = k;
                                s.nT = n;
                                for (var t = q.length - 1; t >= 0; t--) {
                                    if (q[t].nT <= n) {
                                        q.splice(t + 1, 0, s);
                                        return;
                                    }
                                }
                                q.unshift(s);
                            }
                        },
                        oW: (function() {
                            var j = false,
                                    k = function() {
                                        j = true;
                                    }, l = false,
                                    m = function(n) {
                                        l = n ? 2 : true;
                                    };
                            return function y(n, o, p, q) {
                                if (typeof o == 'function') {
                                    q = o;
                                    o = null;
                                } else if (typeof p == 'function') {
                                    q = p;
                                    p = null;
                                }
                                if (n != 'mousemove')
                                    a.log('[EVENT] ' + n, o, q);
                                var r = h(this)[n],
                                        s = j,
                                        t = l;
                                j = l = false;
                                if (r) {
                                    var u = r.dF;
                                    if (u.length) {
                                        u = u.slice(0);
                                        for (var v = 0; v < u.length; v++) {
                                            var w = u[v].call(this, p, o, k, m);
                                            if (typeof w != 'undefined')
                                                o = w;
                                            if (j || l && l != 2)
                                                break;
                                        }
                                    }
                                }
                                var x = l || (typeof o == 'undefined' ? false : !o || typeof o.result == 'undefined' ? o : o.result);
                                if (typeof q === 'function' && l != 2)
                                    x = q.call(this, l, o) || x;
                                j = s;
                                l = t;
                                return x;
                            };
                        })(),
                        cr: function(j, k, l) {
                            var m = this.oW(j, k, l);
                            delete h(this)[j];
                            return m;
                        },
                        removeListener: function(j, k) {
                            var l = h(this)[j];
                            if (l) {
                                var m = l.mi(k);
                                if (m >= 0)
                                    l.dF.splice(m, 1);
                            }
                        },
                        mF: function() {
                            var j = h(this);
                            for (var k = 0; k < j.length; k++)
                                j[k].dF = [];
                        },
                        rC: function(j) {
                            var k = h(this)[j];
                            return k && k.dF.length > 0;
                        }
                    };
                })();
            }
            if (!a.application) {
                a.kZ = 0;
                a.fc = 1;
                a.qE = 2;
                a.application = function(h, i, j, k) {
                    var l = this;
                    l._ = {
                        instanceConfig: h,
                        element: i
                    };
                    l.ff = j || a.kZ;
                    a.event.call(l);
                    l.iI(k);
                };
                a.application.replace = function(h, i, j) {
                    var k = h;
                    if (typeof k != 'object') {
                        k = document.getElementById(h);
                        if (!k) {
                            var l = 0,
                                    m = document.getElementsByName(h);
                            while ((k = m[l++]) && k.tagName.toLowerCase() != 'textarea') {
                            }
                        }
                        if (!k)
                            throw '[CKFINDER.application.replace] The element with id or name "' + h + '" was not found.';
                    }
                    return new a.application(i, k, a.fc, j);
                };
                a.application.appendTo = function(h, i, j) {
                    if (typeof h != 'object') {
                        h = document.getElementById(h);
                        if (!h)
                            throw '[CKFINDER.application.appendTo] The element with id "' + h + '" was not found.';
                    }
                    return new a.application(i, h, a.qE, j);
                };
                a.application.prototype = {
                    iI: function() {
                        var h = a.application.eb || (a.application.eb = []);
                        h.push(this);
                    },
                    oW: function(h, i, j) {
                        return a.event.prototype.oW.call(this, h, i, this, j);
                    },
                    cr: function(h, i, j) {
                        return a.event.prototype.cr.call(this, h, i, this, j);
                    }
                };
                a.event.du(a.application.prototype, true);
            }
            if (!a.env) {
                var f = /rv:([\d\.]+)/,
                        g = /trident\/([\d]+)/;
                a.env = (function() {
                    var h = navigator.userAgent.toLowerCase(),
                            i = window.opera,
                            j = {
                                ie:
                                        /*@cc_on!@*/
                                        false,
                                iemodern: false,
                                opera: !!i && i.version,
                                webkit: h.indexOf(' applewebkit/') > -1,
                                air: h.indexOf(' adobeair/') > -1,
                                mac: h.indexOf('macintosh') > -1,
                                quirks: document.compatMode == 'BackCompat',
                                isCustomDomain: function() {
                                    return this.ie && document.domain != window.location.hostname;
                                }
                            };
                    j.gecko = navigator.product == 'Gecko' && !j.webkit && !j.opera;
                    j.chrome = false;
                    j.safari = false;
                    if (j.webkit)
                        if (h.indexOf(' chrome/') > -1)
                            j.chrome = true;
                        else
                            j.safari = true;
                    var k = 0;
                    if (j.ie) {
                        k = parseFloat(h.match(/msie (\d+)/)[1]);
                        j.ie8 = !!document.documentMode;
                        j.ie8Compat = document.documentMode == 8;
                        j.ie7Compat = k == 7 && !document.documentMode || document.documentMode == 7;
                        j.ie6Compat = k < 7 || j.quirks;
                    }
                    if (j.gecko) {
                        var l = h.match(f);
                        if (l) {
                            l = l[1].split('.');
                            k = l[0] * 10000 + (l[1] || 0) * 100 + +(l[2] || 0);
                        }
                        if (g.test(h)) {
                            j.gecko = false;
                            j.iemodern = true;
                        } else
                            j.isMobile = h.indexOf('fennec') > -1;
                    }
                    if (j.opera) {
                        k = parseFloat(i.version());
                        j.isMobile = h.indexOf('opera mobi') > -1;
                    }
                    if (j.air)
                        k = parseFloat(h.match(/ adobeair\/(\d+)/)[1]);
                    if (j.webkit) {
                        k = parseFloat(h.match(/ applewebkit\/(\d+)/)[1]);
                        j.isMobile = h.indexOf('mobile') > -1;
                    }
                    j.version = k;
                    j.isCompatible = j.ie && k >= 6 || j.iemodern && k >= 11 || j.gecko && k >= 10801 || j.opera && k >= 9.5 || j.air && k >= 1 || j.webkit && k >= 522 || false;
                    j.cssClass = 'browser_' + (j.ie ? 'ie' : j.iemodern ? 'iemodern' : j.gecko ? 'gecko' : j.opera ? 'opera' : j.air ? 'air' : j.webkit ? 'webkit' : 'unknown');
                    if (j.quirks)
                        j.cssClass += ' browser_quirks';
                    if (j.ie) {
                        j.cssClass += ' browser_ie' + (j.version < 7 ? '6' : j.version >= 8 ? '8' : '7');
                        if (j.quirks)
                            j.cssClass += ' browser_iequirks';
                        if (j.ie7Compat)
                            j.cssClass += ' browser_ie7Compat';
                    }
                    if (j.gecko && k < 10900)
                        j.cssClass += ' browser_gecko18';
                    return j;
                })();
                CKFinder.env = a.env;
            }
            var h = a.env;
            var i = h.ie;
            if (a.status == 'unloaded')
                (function() {
                    a.event.du(a);
                    a.dO = function() {
                        if (a.status != 'basic_ready') {
                            a.dO.qr = true;
                            return;
                        }
                        delete a.dO;
                        var k = document.createElement('script');
                        k.type = 'text/javascript';
                        k.src = a.basePath + 'ckfinder.js';
                        document.getElementsByTagName('head')[0].appendChild(k);
                    };
                    a.mS = 0;
                    a.uQ = 'ckfinder';
                    a.uM = true;
                    var j = function(k, l, m, n) {
                        if (h.isCompatible) {
                            if (a.dO)
                                a.dO();
                            var o = m(k, l, n);
                            a.add(o);
                            return o;
                        }
                        return null;
                    };
                    a.replace = function(k, l, m) {
                        return j(k, l, a.application.replace, m);
                    };
                    a.appendTo = function(k, l, m) {
                        return j(k, l, a.application.appendTo, m);
                    };
                    a.add = function(k) {
                        var l = this._.io || (this._.io = []);
                        l.push(k);
                    };
                    a.uL = function() {
                        var k = document.getElementsByTagName('textarea');
                        for (var l = 0; l < k.length; l++) {
                            var m = null,
                                    n = k[l],
                                    o = n.name;
                            if (!n.name && !n.id)
                                continue;
                            if (typeof arguments[0] == 'string') {
                                var p = new RegExp('(?:^| )' + arguments[0] + '(?:$| )');
                                if (!p.test(n.className))
                                    continue;
                            } else if (typeof arguments[0] == 'function') {
                                m = {};
                                if (arguments[0](n, m) === false)
                                    continue;
                            }
                            this.replace(n, m);
                        }
                    };
                    (function() {
                        var k = function() {
                            var l = a.dO,
                                    m = a.mS;
                            a.status = 'basic_ready';
                            if (l && l.qr)
                                l();
                            else if (m)
                                setTimeout(function() {
                                    if (a.dO)
                                        a.dO();
                                }, m * 1000);
                        };
                        if (window.addEventListener)
                            window.addEventListener('load', k, false);
                        else if (window.attachEvent)
                            window.attachEvent('onload', k);
                    })();
                    a.status = 'basic_loaded';
                })();
            a.dom = {};
            CKFinder.dom = a.dom;
            var j = a.dom;
            a.ajax = (function() {
                var k = function() {
                    if (!i || location.protocol != 'file:')
                        try {
                            return new XMLHttpRequest();
                        } catch (p) {
                        }
                    try {
                        return new ActiveXObject('Msxml2.XMLHTTP');
                    } catch (q) {
                    }
                    try {
                        return new ActiveXObject('Microsoft.XMLHTTP');
                    } catch (r) {
                    }
                    return null;
                }, l = function(p) {
                    return p.readyState == 4 && (p.status >= 200 && p.status < 300 || p.status == 304 || p.status === 0 || p.status == 1223);
                }, m = function(p) {
                    if (l(p))
                        return p.responseText;
                    return null;
                }, n = function(p) {
                    if (l(p)) {
                        var q = p.responseXML,
                                r = new a.xml(q && q.firstChild && q.documentElement && q.documentElement.nodeName != 'parsererror' ? q : p.responseText.replace(/^[^<]+/, '').replace(/[^>]+$/, ''));
                        if (r && r.mq && r.mq.documentElement && r.mq.documentElement.nodeName != 'parsererror' && r.mq.documentElement.nodeName != 'html' && r.mq.documentElement.nodeName != 'br')
                            return r;
                    }
                    var s = a.nG || a.jt,
                            t = p.responseText,
                            u = s.lang.ErrorMsg[!t ? 'XmlEmpty' : 'XmlError'] + '<br>';
                    if (r && r.mq)
                        if (r.mq.parseError && r.mq.parseError.reason)
                            u += r.mq.parseError.reason;
                        else if (r.mq.documentElement && r.mq.documentElement.nodeName == 'parsererror')
                            u += r.mq.documentElement.textContent;
                    if (!t)
                        s.msgDialog(s.lang.SysErrorDlgTitle, u);
                    else {
                        if (/text\/plain/.test(p.getResponseHeader('Content-Type')) || /<Connector\s*/.test(t)) {
                            t = a.tools.htmlEncode(t);
                            t = t.replace(/\n/g, '<br>');
                            t = '<div style="width:600px; overflow:scroll"><font>' + t + '</font></div>';
                        }
                        s.msgDialog(s.lang.SysErrorDlgTitle, u + '<br>' + s.lang.ErrorMsg.XmlRawResponse.replace('%s', '<br><br>' + t));
                    }
                    return {};
                }, o = function(p, q, r, s) {
                    var t = !!q;
                    a.log('[AJAX] ' + (s ? 'POST' : 'GET') + ' ' + p);
                    var u = k();
                    if (!u)
                        return null;
                    if (!s)
                        u.open('GET', p, t);
                    else
                        u.open('POST', p, t);
                    if (t)
                        u.onreadystatechange = function() {
                            if (u.readyState == 4) {
                                q(r(u));
                                u = null;
                            }
                        };
                    if (s) {
                        u.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=utf-8');
                        u.send(s);
                    } else
                        u.send(null);
                    return t ? '' : r(u);
                };
                return {
                    load: function(p, q, r) {
                        return o(p, q, m, r);
                    },
                    loadXml: function(p, q, r) {
                        return o(p, q, n, r);
                    }
                };
            })();
            CKFinder.ajax = a.ajax;
            (function() {
                var k = [];
                a.tools = {
                    arrayCompare: function(l, m) {
                        if (!l && !m)
                            return true;
                        if (!l || !m || l.length != m.length)
                            return false;
                        for (var n = 0; n < l.length; n++) {
                            if (l[n] != m[n])
                                return false;
                        }
                        return true;
                    },
                    clone: function(l) {
                        var m;
                        if (l && l instanceof Array) {
                            m = [];
                            for (var n = 0; n < l.length; n++)
                                m[n] = this.clone(l[n]);
                            return m;
                        }
                        if (l === null || typeof l != 'object' || l instanceof String || l instanceof Number || l instanceof Boolean || l instanceof Date)
                            return l;
                        m = new l.constructor();
                        for (var o in l) {
                            var p = l[o];
                            m[o] = this.clone(p);
                        }
                        return m;
                    },
                    capitalize: function(l) {
                        return l.charAt(0).toUpperCase() + l.substring(1).toLowerCase();
                    },
                    extend: function(l) {
                        var m = arguments.length,
                                n, o;
                        if (typeof (n = arguments[m - 1]) == 'boolean')
                            m--;
                        else if (typeof (n = arguments[m - 2]) == 'boolean') {
                            o = arguments[m - 1];
                            m -= 2;
                        }
                        for (var p = 1; p < m; p++) {
                            var q = arguments[p];
                            for (var r in q) {
                                if (n === true || l[r] == undefined)
                                    if (!o || r in o)
                                        l[r] = q[r];
                            }
                        }
                        return l;
                    },
                    prototypedCopy: function(l) {
                        var m = function() {
                        };
                        m.prototype = l;
                        return new m();
                    },
                    isArray: function(l) {
                        return !!l && l instanceof Array;
                    },
                    cssStyleToDomStyle: (function() {
                        var l = document.createElement('div').style,
                                m = typeof l.cssFloat != 'undefined' ? 'cssFloat' : typeof l.styleFloat != 'undefined' ? 'styleFloat' : 'float';
                        return function(n) {
                            if (n == 'float')
                                return m;
                            else
                                return n.replace(/-./g, function(o) {
                                    return o.substr(1).toUpperCase();
                                });
                        };
                    })(),
                    htmlEncode: function(l) {
                        var m = function(q) {
                            var r = new j.element('span');
                            r.setText(q);
                            return r.getHtml();
                        }, n = m('\n').toLowerCase() == '<br>' ? function(q) {
                            return m(q).replace(/<br>/gi, '\n');
                        } : m,
                                o = m('>') == '>' ? function(q) {
                            return n(q).replace(/>/g, '&gt;');
                        } : n,
                                p = m('  ') == '&nbsp; ' ? function(q) {
                            return o(q).replace(/&nbsp;/g, ' ');
                        } : o;
                        this.htmlEncode = p;
                        return this.htmlEncode(l);
                    },
                    getNextNumber: (function() {
                        var l = 0;
                        return function() {
                            return ++l;
                        };
                    })(),
                    override: function(l, m) {
                        return m(l);
                    },
                    setTimeout: function(l, m, n, o, p) {
                        if (!p)
                            p = window;
                        if (!n)
                            n = p;
                        return p.setTimeout(function() {
                            if (o)
                                l.apply(n, [].concat(o));
                            else
                                l.apply(n);
                        }, m || 0);
                    },
                    trim: (function() {
                        var l = /(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g;
                        return function(m) {
                            return m ? m.replace(l, '') : null;
                        };
                    })(),
                    ltrim: (function() {
                        var l = /^[ \t\n\r]+/g;
                        return function(m) {
                            return m ? m.replace(l, '') : null;
                        };
                    })(),
                    rtrim: (function() {
                        var l = /[ \t\n\r]+$/g;
                        return function(m) {
                            return m ? m.replace(l, '') : null;
                        };
                    })(),
                    indexOf: Array.prototype.indexOf ? function(l, m) {
                        return l.indexOf(m);
                    } : function(l, m) {
                        for (var n = 0, o = l.length; n < o; n++) {
                            if (l[n] === m)
                                return n;
                        }
                        return -1;
                    },
                    bind: function(l, m) {
                        return function() {
                            return l.apply(m, arguments);
                        };
                    },
                    createClass: function(l) {
                        var m = l.$,
                                n = l.base,
                                o = l.vd || l._,
                                p = l.ej,
                                q = l.statics;
                        if (o) {
                            var r = m;
                            m = function() {
                                var v = this;
                                var s = v._ || (v._ = {});
                                for (var t in o) {
                                    var u = o[t];
                                    s[t] = typeof u == 'function' ? a.tools.bind(u, v) : u;
                                }
                                r.apply(v, arguments);
                            };
                        }
                        if (n) {
                            m.prototype = this.prototypedCopy(n.prototype);
                            m.prototype['constructor'] = m;
                            m.prototype.base = function() {
                                this.base = n.prototype.base;
                                n.apply(this, arguments);
                                this.base = arguments.callee;
                            };
                        }
                        if (p)
                            this.extend(m.prototype, p, true);
                        if (q)
                            this.extend(m, q, true);
                        return m;
                    },
                    addFunction: function(l, m) {
                        return k.push(function() {
                            l.apply(m || this, arguments);
                        }) - 1;
                    },
                    removeFunction: function(l) {
                        k[l] = null;
                    },
                    callFunction: function(l) {
                        var m = k[l];
                        return m.apply(window, Array.prototype.slice.call(arguments, 1));
                    },
                    cssLength: (function() {
                        var l = /^\d+(?:\.\d+)?$/;
                        return function(m) {
                            return m + (l.test(m) ? 'px' : '');
                        };
                    })(),
                    repeat: function(l, m) {
                        return new Array(m + 1).join(l);
                    },
                    deepCopy: function(l) {
                        var m = {};
                        if (typeof l == 'object') {
                            if (typeof l.length != 'undefined')
                                m = [];
                            for (var n in l) {
                                if (l[n] === null)
                                    m[n] = null;
                                else if (typeof l[n] == 'object')
                                    m[n] = a.tools.deepCopy(l[n]);
                                else
                                    m[n] = l[n];
                            }
                        }
                        return m;
                    },
                    getUrlParam: function(l, m) {
                        var n = new RegExp('(?:[?&]|&amp;)' + l + '=([^&]+)', 'i'),
                                o = (m || window).location.search.match(n);
                        return o && o.length > 1 ? o[1] : null;
                    },
                    htmlEncode: function(l) {
                        if (!l)
                            return '';
                        l = typeof l != 'string' ? l.toString() : l;
                        l = l.replace(/&/g, '&amp;');
                        l = l.replace(/</g, '&lt;');
                        l = l.replace(/>/g, '&gt;');
                        return l;
                    },
                            setCookie: function(l, m, n) {
                                document.cookie = l + '=' + m + (!n ? '; expires=Thu, 6 Oct 2016 01:00:00 UTC; path=/' : '');
                            },
                    getCookie: function(l) {
                        var m = document.cookie.match(new RegExp('(^|\\s|;)' + l + '=([^;]*)'));
                        return m && m.length > 0 ? m[2] : '';
                    },
                    mH: function(l) {
                        if (i) {
                            l.$.onfocusin = function() {
                                l.addClass('focus_inside');
                            };
                            l.$.onfocusout = function() {
                                l.removeClass('focus_inside');
                            };
                        } else {
                            l.$.addEventListener('focus', function() {
                                l.addClass('focus_inside');
                            }, true);
                            l.$.addEventListener('blur', function() {
                                l.removeClass('focus_inside');
                            }, true);
                        }
                    },
                    formatSize: function(l, m, n) {
                        if (l == 0)
                            return '0';
                        if (l < 1)
                            return m.Kb.replace('%1', 1);
                        if (l < 1024) {
                            if (!n)
                                l = l.toFixed(2);
                            return m.Kb.replace('%1', l);
                        }
                        if (l < 1048576)
                            return m.Mb.replace('%1', (l / 1024).toFixed(2));
                        return m.Gb.replace('%1', (l / 1048576).toFixed(2));
                    },
                    formatSpeed: function(l, m) {
                        return m.SizePerSecond.replace('%1', this.formatSize(l, m));
                    }
                };
                CKFinder._.callFunction = a.tools.callFunction;
                CKFinder.tools = a.tools;
            })();
            var k = a.tools;
            j.event = function(l) {
                this.$ = l;
            };
            j.event.prototype = {
                oV: function() {
                    return this.$.keyCode || this.$.which || 0;
                },
                db: function() {
                    var m = this;
                    var l = m.oV();
                    if (m.$.ctrlKey || m.$.metaKey)
                        l += a.bP;
                    if (m.$.shiftKey)
                        l += a.dy;
                    if (m.$.altKey)
                        l += a.eJ;
                    return l;
                },
                preventDefault: function(l) {
                    var m = this.$;
                    if (m.preventDefault)
                        m.preventDefault();
                    else
                        m.returnValue = false;
                    if (l)
                        this.stopPropagation();
                },
                stopPropagation: function() {
                    var l = this.$;
                    if (l.stopPropagation)
                        l.stopPropagation();
                    else
                        l.cancelBubble = true;
                },
                bK: function() {
                    var l = this.$.target || this.$.srcElement;
                    return l ? new j.bi(l) : null;
                },
                getButton: function() {
                    if (this.$.which)
                        return this.$.which;
                    switch (this.$.button) {
                        case 1:
                            return 1;
                        case 4:
                            return 2;
                        case 2:
                            return 3;
                    }
                },
                ov: function() {
                    return 1 == this.getButton();
                }
            };
            a.bP = 1000;
            a.dy = 2000;
            a.eJ = 4000;
            j.dE = function(l) {
                if (l)
                    this.$ = l;
            };
            j.dE.prototype = (function() {
                var l = function(m, n) {
                    return function(o) {
                        if (typeof a != 'undefined')
                            m.oW(n, new j.event(o));
                    };
                };
                return {
                    kk: function() {
                        var m;
                        if (!(m = this.dw('_')))
                            this.fL('_', m = {});
                        return m;
                    },
                    on: function(m) {
                        var p = this;
                        var n = p.dw('_cke_nativeListeners');
                        if (!n) {
                            n = {};
                            p.fL('_cke_nativeListeners', n);
                        }
                        if (!n[m]) {
                            var o = n[m] = l(p, m);
                            if (p.$.addEventListener)
                                p.$.addEventListener(m, o, !!a.event.jP);
                            else if (p.$.attachEvent)
                                p.$.attachEvent('on' + m, o);
                        }
                        return a.event.prototype.on.apply(p, arguments);
                    },
                    removeListener: function(m) {
                        var p = this;
                        a.event.prototype.removeListener.apply(p, arguments);
                        if (!p.rC(m)) {
                            var n = p.dw('_cke_nativeListeners'),
                                    o = n && n[m];
                            if (o) {
                                if (p.$.removeEventListener)
                                    p.$.removeEventListener(m, o, false);
                                else if (p.$.detachEvent)
                                    p.$.detachEvent('on' + m, o);
                                delete n[m];
                            }
                        }
                    }
                };
            })();
            (function(l) {
                var m = {};
                l.equals = function(n) {
                    return n && n.$ === this.$;
                };
                l.fL = function(n, o) {
                    var p = this.iY(),
                            q = m[p] || (m[p] = {});
                    q[n] = o;
                    return this;
                };
                l.dw = function(n) {
                    var o = this.$._ckf_expando,
                            p = o && m[o];
                    return p && p[n];
                };
                l.jF = function(n) {
                    var o = this.$._ckf_expando,
                            p = o && m[o],
                            q = p && p[n];
                    if (typeof q != 'undefined')
                        delete p[n];
                    return q || null;
                };
                l.iY = function() {
                    return this.$._ckf_expando || (this.$._ckf_expando = k.getNextNumber());
                };
                a.event.du(l);
            })(j.dE.prototype);
            j.window = function(l) {
                j.dE.call(this, l);
            };
            j.window.prototype = new j.dE();
            k.extend(j.window.prototype, {
                focus: function() {
                    if (h.webkit && this.$.parent)
                        this.$.parent.focus();
                    this.$.focus();
                },
                eR: function() {
                    var l = this.$.document,
                            m = l.compatMode == 'CSS1Compat';
                    return {
                        width: (m ? l.documentElement.clientWidth : l.body.clientWidth) || 0,
                        height: (m ? l.documentElement.clientHeight : l.body.clientHeight) || 0
                    };
                },
                hV: function() {
                    var l = this.$;
                    if ('pageXOffset' in l)
                        return {
                            x: l.pageXOffset || 0,
                            y: l.pageYOffset || 0
                        };
                    else {
                        var m = l.document;
                        return {
                            x: m.documentElement.scrollLeft || m.body.scrollLeft || 0,
                            y: m.documentElement.scrollTop || m.body.scrollTop || 0
                        };
                    }
                }
            });
            j.document = function(l) {
                j.dE.call(this, l);
            };
            var l = j.document;
            l.prototype = new j.dE();
            k.extend(l.prototype, {
                appendStyleSheet: function(m) {
                    if (this.$.createStyleSheet)
                        this.$.createStyleSheet(m);
                    else {
                        var n = new j.element('link');
                        n.setAttributes({
                            rel: 'stylesheet',
                            type: 'text/css',
                            href: m
                        });
                        this.getHead().append(n);
                    }
                },
                createElement: function(m, n) {
                    var o = new j.element(m, this);
                    if (n) {
                        if (n.attributes)
                            o.setAttributes(n.attributes);
                        if (n.gS)
                            o.setStyles(n.gS);
                    }
                    return o;
                },
                jT: function(m) {
                    return new j.text(m, this);
                },
                focus: function() {
                    this.getWindow().focus();
                },
                getById: function(m) {
                    var n = this.$.getElementById(m);
                    return n ? new j.element(n) : null;
                },
                vu: function(m, n) {
                    var o = this.$.documentElement;
                    for (var p = 0; o && p < m.length; p++) {
                        var q = m[p];
                        if (!n) {
                            o = o.childNodes[q];
                            continue;
                        }
                        var r = -1;
                        for (var s = 0; s < o.childNodes.length; s++) {
                            var t = o.childNodes[s];
                            if (n === true && t.nodeType == 3 && t.previousSibling && t.previousSibling.nodeType == 3)
                                continue;
                            r++;
                            if (r == q) {
                                o = t;
                                break;
                            }
                        }
                    }
                    return o ? new j.bi(o) : null;
                },
                eG: function(m, n) {
                    if (!i && n)
                        m = n + ':' + m;
                    return new j.iT(this.$.getElementsByTagName(m));
                },
                getHead: function() {
                    var m = this.$.getElementsByTagName('head')[0];
                    m = new j.element(m);
                    return (this.getHead = function() {
                        return m;
                    })();
                },
                bH: function() {
                    var m = new j.element(this.$.body);
                    return (this.bH = function() {
                        return m;
                    })();
                },
                gT: function() {
                    var m = new j.element(this.$.documentElement);
                    return (this.gT = function() {
                        return m;
                    })();
                },
                getWindow: function() {
                    var m = new j.window(this.$.parentWindow || this.$.defaultView);
                    return (this.getWindow = function() {
                        return m;
                    })();
                }
            });
            j.bi = function(m) {
                if (m) {
                    switch (m.nodeType) {
                        case a.cv:
                            return new j.element(m);
                        case a.fl:
                            return new j.text(m);
                    }
                    j.dE.call(this, m);
                }
                return this;
            };
            j.bi.prototype = new j.dE();
            a.cv = 1;
            a.fl = 3;
            a.va = 8;
            a.om = 11;
            a.oh = 0;
            a.op = 1;
            a.gW = 2;
            a.gX = 4;
            a.mo = 8;
            a.lF = 16;
            k.extend(j.bi.prototype, {
                appendTo: function(m, n) {
                    m.append(this, n);
                    return m;
                },
                clone: function(m, n) {
                    var o = this.$.cloneNode(m);
                    if (!n) {
                        var p = function(q) {
                            if (q.nodeType != a.cv)
                                return;
                            q.removeAttribute('id', false);
                            q.removeAttribute('_ckf_expando', false);
                            var r = q.childNodes;
                            for (var s = 0; s < r.length; s++)
                                p(r[s]);
                        };
                        p(o);
                    }
                    return new j.bi(o);
                },
                gE: function() {
                    return !!this.$.previousSibling;
                },
                ge: function() {
                    return !!this.$.nextSibling;
                },
                kB: function(m) {
                    m.$.parentNode.insertBefore(this.$, m.$.nextSibling);
                    return m;
                },
                insertBefore: function(m) {
                    m.$.parentNode.insertBefore(this.$, m.$);
                    return m;
                },
                vP: function(m) {
                    this.$.parentNode.insertBefore(m.$, this.$);
                    return m;
                },
                lU: function(m) {
                    var n = [],
                            o = this.getDocument().$.documentElement,
                            p = this.$;
                    while (p && p != o) {
                        var q = p.parentNode,
                                r = -1;
                        for (var s = 0; s < q.childNodes.length; s++) {
                            var t = q.childNodes[s];
                            if (m && t.nodeType == 3 && t.previousSibling && t.previousSibling.nodeType == 3)
                                continue;
                            r++;
                            if (t == p)
                                break;
                        }
                        n.unshift(r);
                        p = p.parentNode;
                    }
                    return n;
                },
                getDocument: function() {
                    var m = new l(this.$.ownerDocument || this.$.parentNode.ownerDocument);
                    return (this.getDocument = function() {
                        return m;
                    })();
                },
                vA: function() {
                    var m = this.$,
                            n = m.parentNode && m.parentNode.firstChild,
                            o = -1;
                    while (n) {
                        o++;
                        if (n == m)
                            return o;
                        n = n.nextSibling;
                    }
                    return -1;
                },
                hL: function(m, n, o) {
                    if (o && !o.call) {
                        var p = o;
                        o = function(s) {
                            return !s.equals(p);
                        };
                    }
                    var q = !m && this.getFirst && this.getFirst(),
                            r;
                    if (!q) {
                        if (this.type == a.cv && o && o(this, true) === false)
                            return null;
                        q = this.dG();
                    }
                    while (!q && (r = (r || this).getParent())) {
                        if (o && o(r, true) === false)
                            return null;
                        q = r.dG();
                    }
                    if (!q)
                        return null;
                    if (o && o(q) === false)
                        return null;
                    if (n && n != q.type)
                        return q.hL(false, n, o);
                    return q;
                },
                hZ: function(m, n, o) {
                    if (o && !o.call) {
                        var p = o;
                        o = function(s) {
                            return !s.equals(p);
                        };
                    }
                    var q = !m && this.dB && this.dB(),
                            r;
                    if (!q) {
                        if (this.type == a.cv && o && o(this, true) === false)
                            return null;
                        q = this.cf();
                    }
                    while (!q && (r = (r || this).getParent())) {
                        if (o && o(r, true) === false)
                            return null;
                        q = r.cf();
                    }
                    if (!q)
                        return null;
                    if (o && o(q) === false)
                        return null;
                    if (n && q.type != n)
                        return q.hZ(false, n, o);
                    return q;
                },
                cf: function(m) {
                    var n = this.$,
                            o;
                    do {
                        n = n.previousSibling;
                        o = n && new j.bi(n);
                    } while (o && m && !m(o));
                    return o;
                },
                vs: function() {
                    return this.cf(function(m) {
                        return m.$.nodeType == 1;
                    });
                },
                dG: function(m) {
                    var n = this.$,
                            o;
                    do {
                        n = n.nextSibling;
                        o = n && new j.bi(n);
                    } while (o && m && !m(o));
                    return o;
                },
                vk: function() {
                    return this.dG(function(m) {
                        return m.$.nodeType == 1;
                    });
                },
                getParent: function() {
                    var m = this.$.parentNode;
                    return m && m.nodeType == 1 ? new j.bi(m) : null;
                },
                vn: function(m) {
                    var n = this,
                            o = [];
                    do
                        o[m ? 'push' : 'unshift'](n);
                    while (n = n.getParent());
                    return o;
                },
                vv: function(m) {
                    var o = this;
                    if (m.equals(o))
                        return o;
                    if (m.contains && m.contains(o))
                        return m;
                    var n = o.contains ? o : o.getParent();
                    do {
                        if (n.contains(m))
                            return n;
                    } while (n = n.getParent());
                    return null;
                },
                gz: function(m) {
                    var n = this.$,
                            o = m.$;
                    if (n.compareDocumentPosition)
                        return n.compareDocumentPosition(o);
                    if (n == o)
                        return a.oh;
                    if (this.type == a.cv && m.type == a.cv) {
                        if (n.contains) {
                            if (n.contains(o))
                                return a.lF + a.gX;
                            if (o.contains(n))
                                return a.mo + a.gW;
                        }
                        if ('sourceIndex' in n)
                            return n.sourceIndex < 0 || o.sourceIndex < 0 ? a.op : n.sourceIndex < o.sourceIndex ? a.gX : a.gW;
                    }
                    var p = this.lU(),
                            q = m.lU(),
                            r = Math.min(p.length, q.length);
                    for (var s = 0; s <= r - 1; s++) {
                        if (p[s] != q[s]) {
                            if (s < r)
                                return p[s] < q[s] ? a.gX : a.gW;
                            break;
                        }
                    }
                    return p.length < q.length ? a.lF + a.gX : a.mo + a.gW;
                },
                vw: function(m, n) {
                    var o = this.$;
                    if (!n)
                        o = o.parentNode;
                    while (o) {
                        if (o.nodeName && o.nodeName.toLowerCase() == m)
                            return new j.bi(o);
                        o = o.parentNode;
                    }
                    return null;
                },
                vX: function(m, n) {
                    var o = this.$;
                    if (!n)
                        o = o.parentNode;
                    while (o) {
                        if (o.nodeName && o.nodeName.toLowerCase() == m)
                            return true;
                        o = o.parentNode;
                    }
                    return false;
                },
                move: function(m, n) {
                    m.append(this.remove(), n);
                },
                remove: function(m) {
                    var n = this.$,
                            o = n.parentNode;
                    if (o) {
                        if (m)
                            for (var p; p = n.firstChild; )
                                o.insertBefore(n.removeChild(p), n);
                        o.removeChild(n);
                    }
                    return this;
                },
                replace: function(m) {
                    this.insertBefore(m);
                    m.remove();
                },
                trim: function() {
                    this.ltrim();
                    this.rtrim();
                },
                ltrim: function() {
                    var p = this;
                    var m;
                    while (p.getFirst && (m = p.getFirst())) {
                        if (m.type == a.fl) {
                            var n = k.ltrim(m.getText()),
                                    o = m.hJ();
                            if (!n) {
                                m.remove();
                                continue;
                            } else if (n.length < o) {
                                m.split(o - n.length);
                                p.$.removeChild(p.$.firstChild);
                            }
                        }
                        break;
                    }
                },
                rtrim: function() {
                    var p = this;
                    var m;
                    while (p.dB && (m = p.dB())) {
                        if (m.type == a.fl) {
                            var n = k.rtrim(m.getText()),
                                    o = m.hJ();
                            if (!n) {
                                m.remove();
                                continue;
                            } else if (n.length < o) {
                                m.split(n.length);
                                p.$.lastChild.parentNode.removeChild(p.$.lastChild);
                            }
                        }
                        break;
                    }
                    if (!i && !h.opera) {
                        m = p.$.lastChild;
                        if (m && m.type == 1 && m.nodeName.toLowerCase() == 'br')
                            m.parentNode.removeChild(m);
                    }
                }
            });
            j.iT = function(m) {
                this.$ = m;
            };
            j.iT.prototype = {
                count: function() {
                    return this.$.length;
                },
                getItem: function(m) {
                    var n = this.$[m];
                    return n ? new j.bi(n) : null;
                }
            };
            j.element = function(m, n) {
                if (typeof m == 'string')
                    m = (n ? n.$ : document).createElement(m);
                j.dE.call(this, m);
            };
            var m = j.element;
            m.eB = function(n) {
                return n && (n.$ ? n : new m(n));
            };
            m.prototype = new j.bi();
            m.kE = function(n, o) {
                var p = new m('div', o);
                p.setHtml(n);
                return p.getFirst().remove();
            };
            m.rS = function(n, o, p, q) {
                var r = o.dw('list_marker_id') || o.fL('list_marker_id', k.getNextNumber()).dw('list_marker_id'),
                        s = o.dw('list_marker_names') || o.fL('list_marker_names', {}).dw('list_marker_names');
                n[r] = o;
                s[p] = 1;
                return o.fL(p, q);
            };
            m.sM = function(n) {
                for (var o in n)
                    m.qZ(n, n[o], true);
            };
            m.qZ = function(n, o, p) {
                var q = o.dw('list_marker_names'),
                        r = o.dw('list_marker_id');
                for (var s in q)
                    o.jF(s);
                o.jF('list_marker_names');
                if (p) {
                    o.jF('list_marker_id');
                    delete n[r];
                }
            };
            k.extend(m.prototype, {
                type: a.cv,
                addClass: function(n) {
                    var o = this.$.className;
                    if (o) {
                        var p = new RegExp('(?:^|\\s)' + n + '(?:\\s|$)', '');
                        if (!p.test(o))
                            o += ' ' + n;
                    }
                    this.$.className = o || n;
                },
                removeClass: function(n) {
                    var o = this.getAttribute('class');
                    if (o) {
                        var p = new RegExp('(?:^|\\s+)' + n + '(?=\\s|$)', 'i');
                        if (p.test(o)) {
                            o = o.replace(p, '').replace(/^\s+/, '');
                            if (o)
                                this.setAttribute('class', o);
                            else
                                this.removeAttribute('class');
                        }
                    }
                },
                hasClass: function(n) {
                    var o = new RegExp('(?:^|\\s+)' + n + '(?=\\s|$)', '');
                    return o.test(this.getAttribute('class'));
                },
                append: function(n, o) {
                    var p = this;
                    if (typeof n == 'string')
                        n = p.getDocument().createElement(n);
                    if (o)
                        p.$.insertBefore(n.$, p.$.firstChild);
                    else
                        p.$.appendChild(n.$);
                    a.log('[DOM] DOM flush into ' + p.getName());
                    return n;
                },
                appendHtml: function(n) {
                    var p = this;
                    if (!p.$.childNodes.length)
                        p.setHtml(n);
                    else {
                        var o = new m('div', p.getDocument());
                        o.setHtml(n);
                        o.jg(p);
                    }
                },
                appendText: function(n) {
                    if (this.$.text != undefined)
                        this.$.text += n;
                    else
                        this.append(new j.text(n));
                },
                pd: function() {
                    var o = this;
                    var n = o.dB();
                    while (n && n.type == a.fl && !k.rtrim(n.getText()))
                        n = n.cf();
                    if (!n || !n.is || !n.is('br'))
                        o.append(h.opera ? o.getDocument().jT('') : o.getDocument().createElement('br'));
                },
                tV: function(n) {
                    var q = this;
                    var o = new j.mk(q.getDocument());
                    o.setStartAfter(q);
                    o.setEndAfter(n);
                    var p = o.extractContents();
                    o.insertNode(q.remove());
                    p.kA(q);
                },
                contains: i || h.webkit ? function(n) {
                    var o = this.$;
                    return n.type != a.cv ? o.contains(n.getParent().$) : o != n.$ && o.contains(n.$);
                } : function(n) {
                    return !!(this.$.compareDocumentPosition(n.$) & 16);
                },
                focus: function() {
                    try {
                        this.$.focus();
                    } catch (n) {
                    }
                },
                getHtml: function() {
                    return this.$.innerHTML;
                },
                fH: function() {
                    var o = this;
                    if (o.$.outerHTML)
                        return o.$.outerHTML.replace(/<\?[^>]*>/, '');
                    var n = o.$.ownerDocument.createElement('div');
                    n.appendChild(o.$.cloneNode(true));
                    return n.innerHTML;
                },
                setHtml: function(n) {
                    a.log('[DOM] DOM flush into ' + this.getName());
                    return this.$.innerHTML = n;
                },
                setText: function(n) {
                    m.prototype.setText = this.$.innerText != undefined ? function(o) {
                        a.log('[DOM] Text flush');
                        return this.$.innerText = o;
                    } : function(o) {
                        a.log('[DOM] Text flush');
                        return this.$.textContent = o;
                    };
                    return this.setText(n);
                },
                getAttribute: (function() {
                    var n = function(o) {
                        return this.$.getAttribute(o, 2);
                    };
                    if (i && (h.ie7Compat || h.ie6Compat))
                        return function(o) {
                            var q = this;
                            switch (o) {
                                case 'class':
                                    o = 'className';
                                    break;
                                case 'tabindex':
                                    var p = n.call(q, o);
                                    if (p !== 0 && q.$.tabIndex === 0)
                                        p = null;
                                    return p;
                                    break;
                                case 'checked':
                                    return q.$.checked;
                                    break;
                                case 'style':
                                    return q.$.style.cssText;
                            }
                            return n.call(q, o);
                        };
                    else
                        return n;
                })(),
                getChildren: function() {
                    return new j.iT(this.$.childNodes);
                },
                getComputedStyle: i ? function(n) {
                    return this.$.currentStyle[k.cssStyleToDomStyle(n)];
                } : function(n) {
                    return this.getWindow().$.getComputedStyle(this.$, '').getPropertyValue(n);
                },
                pf: function() {
                    var n = a.ga[this.getName()];
                    this.pf = function() {
                        return n;
                    };
                    return n;
                },
                eG: l.prototype.eG,
                vp: i ? function() {
                    var n = this.$.tabIndex;
                    if (n === 0 && !a.ga.ug[this.getName()] && parseInt(this.getAttribute('tabindex'), 10) !== 0)
                        n = -1;
                    return n;
                } : h.webkit ? function() {
                    var n = this.$.tabIndex;
                    if (n == undefined) {
                        n = parseInt(this.getAttribute('tabindex'), 10);
                        if (isNaN(n))
                            n = -1;
                    }
                    return n;
                } : function() {
                    return this.$.tabIndex;
                },
                getText: function() {
                    return this.$.textContent || this.$.innerText || '';
                },
                getWindow: function() {
                    return this.getDocument().getWindow();
                },
                dS: function() {
                    return this.$.id || null;
                },
                data: function(n, o) {
                    n = 'data-' + n;
                    if (o === undefined)
                        return this.getAttribute(n);
                    else if (o === false)
                        this.removeAttribute(n);
                    else
                        this.setAttribute(n, o);
                    return null;
                },
                vm: function() {
                    return this.$.name || null;
                },
                getName: function() {
                    var n = this.$.nodeName.toLowerCase();
                    if (i && !(document.documentMode > 8)) {
                        var o = this.$.scopeName;
                        if (o != 'HTML')
                            n = o.toLowerCase() + ':' + n;
                    }
                    return (this.getName = function() {
                        return n;
                    })();
                },
                getValue: function() {
                    return this.$.value;
                },
                getFirst: function() {
                    var n = this.$.firstChild;
                    return n ? new j.bi(n) : null;
                },
                dB: function(n) {
                    var o = this.$.lastChild,
                            p = o && new j.bi(o);
                    if (p && n && !n(p))
                        p = p.cf(n);
                    return p;
                },
                rd: function(n) {
                    return this.$.style[k.cssStyleToDomStyle(n)];
                },
                is: function() {
                    var n = this.getName();
                    for (var o = 0; o < arguments.length; o++) {
                        if (arguments[o] == n)
                            return true;
                    }
                    return false;
                },
                vL: function() {
                    var n = this.getName(),
                            o = !a.ga.uj[n] && (a.ga[n] || a.ga.span);
                    return o && o['#'];
                },
                isIdentical: function(n) {
                    if (this.getName() != n.getName())
                        return false;
                    var o = this.$.attributes,
                            p = n.$.attributes,
                            q = o.length,
                            r = p.length;
                    if (!i && q != r)
                        return false;
                    for (var s = 0; s < q; s++) {
                        var t = o[s];
                        if ((!i || t.specified && t.nodeName != '_ckf_expando') && t.nodeValue != n.getAttribute(t.nodeName))
                            return false;
                    }
                    if (i)
                        for (s = 0; s < r; s++) {
                            t = p[s];
                            if ((!i || t.specified && t.nodeName != '_ckf_expando') && t.nodeValue != o.getAttribute(t.nodeName))
                                return false;
                        }
                    return true;
                },
                isVisible: function() {
                    return this.$.offsetWidth && this.$.style.visibility != 'hidden';
                },
                hasAttributes: i && (h.ie7Compat || h.ie6Compat) ? function() {
                    var n = this.$.attributes;
                    for (var o = 0; o < n.length; o++) {
                        var p = n[o];
                        switch (p.nodeName) {
                            case 'class':
                                if (this.getAttribute('class'))
                                    return true;
                            case '_ckf_expando':
                                continue;
                            default:
                                if (p.specified)
                                    return true;
                        }
                    }
                    return false;
                } : function() {
                    var n = this.$.attributes;
                    return n.length > 1 || n.length == 1 && n[0].nodeName != '_ckf_expando';
                },
                hasAttribute: function(n) {
                    var o = this.$.attributes.getNamedItem(n);
                    return !!(o && o.specified);
                },
                hide: function() {
                    this.setStyle('display', 'none');
                },
                jg: function(n, o) {
                    var p = this.$;
                    n = n.$;
                    if (p == n)
                        return;
                    var q;
                    if (o)
                        while (q = p.lastChild)
                            n.insertBefore(p.removeChild(q), n.firstChild);
                    else
                        while (q = p.firstChild)
                            n.appendChild(p.removeChild(q));
                },
                show: function() {
                    this.setStyles({
                        display: '',
                        visibility: ''
                    });
                },
                setAttribute: (function() {
                    var n = function(o, p) {
                        this.$.setAttribute(o, p);
                        return this;
                    };
                    if (i && (h.ie7Compat || h.ie6Compat))
                        return function(o, p) {
                            var q = this;
                            if (o == 'class')
                                q.$.className = p;
                            else if (o == 'style')
                                q.$.style.cssText = p;
                            else if (o == 'tabindex')
                                q.$.tabIndex = p;
                            else if (o == 'checked')
                                q.$.checked = p;
                            else
                                n.apply(q, arguments);
                            return q;
                        };
                    else
                        return n;
                })(),
                setAttributes: function(n) {
                    for (var o in n)
                        this.setAttribute(o, n[o]);
                    return this;
                },
                setValue: function(n) {
                    this.$.value = n;
                    return this;
                },
                removeAttribute: (function() {
                    var n = function(o) {
                        this.$.removeAttribute(o);
                    };
                    if (i && (h.ie7Compat || h.ie6Compat))
                        return function(o) {
                            if (o == 'class')
                                o = 'className';
                            else if (o == 'tabindex')
                                o = 'tabIndex';
                            n.call(this, o);
                        };
                    else
                        return n;
                })(),
                uW: function(n) {
                    for (var o = 0; o < n.length; o++)
                        this.removeAttribute(n[o]);
                },
                removeStyle: function(n) {
                    var o = this;
                    if (o.$.style.removeAttribute)
                        o.$.style.removeAttribute(k.cssStyleToDomStyle(n));
                    else
                        o.setStyle(n, '');
                    if (!o.$.style.cssText)
                        o.removeAttribute('style');
                },
                setStyle: function(n, o) {
                    this.$.style[k.cssStyleToDomStyle(n)] = o;
                    return this;
                },
                setStyles: function(n) {
                    for (var o in n)
                        this.setStyle(o, n[o]);
                    return this;
                },
                setOpacity: function(n) {
                    if (i && h.version < 9) {
                        n = Math.round(n * 100);
                        this.setStyle('filter', n >= 100 ? '' : 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + n + ')');
                    } else
                        this.setStyle('opacity', n);
                },
                unselectable: h.gecko ? function() {
                    this.$.style.MozUserSelect = 'none';
                } : h.webkit ? function() {
                    this.$.style.uE = 'none';
                } : function() {
                    if (i || h.opera) {
                        var n = this.$,
                                o, p = 0;
                        n.unselectable = 'on';
                        while (o = n.all[p++])
                            switch (o.tagName.toLowerCase()) {
                                case 'iframe':
                                case 'textarea':
                                case 'input':
                                case 'select':
                                    break;
                                default:
                                    o.unselectable = 'on';
                            }
                    }
                },
                vr: function() {
                    var n = this;
                    while (n.getName() != 'html') {
                        if (n.getComputedStyle('position') != 'static')
                            return n;
                        n = n.getParent();
                    }
                    return null;
                },
                ir: function(n) {
                    var I = this;
                    var o = 0,
                            p = 0,
                            q = I.getDocument().bH(),
                            r = I.getDocument().$.compatMode == 'BackCompat',
                            s = I.getDocument();
                    if (document.documentElement.getBoundingClientRect) {
                        var t = I.$.getBoundingClientRect(),
                                u = s.$,
                                v = u.documentElement,
                                w = v.clientTop || q.$.clientTop || 0,
                                x = v.clientLeft || q.$.clientLeft || 0,
                                y = true;
                        if (i) {
                            var z = s.gT().contains(I),
                                    A = s.bH().contains(I);
                            y = r && A || !r && z;
                        }
                        if (y) {
                            o = t.left + (!r && v.scrollLeft || q.$.scrollLeft);
                            o -= x;
                            p = t.top + (!r && v.scrollTop || q.$.scrollTop);
                            p -= w;
                        }
                    } else {
                        var B = I,
                                C = null,
                                D;
                        while (B && !(B.getName() == 'body' || B.getName() == 'html')) {
                            o += B.$.offsetLeft - B.$.scrollLeft;
                            p += B.$.offsetTop - B.$.scrollTop;
                            if (!B.equals(I)) {
                                o += B.$.clientLeft || 0;
                                p += B.$.clientTop || 0;
                            }
                            var E = C;
                            while (E && !E.equals(B)) {
                                o -= E.$.scrollLeft;
                                p -= E.$.scrollTop;
                                E = E.getParent();
                            }
                            C = B;
                            B = (D = B.$.offsetParent) ? new m(D) : null;
                        }
                    }
                    if (n) {
                        var F = I.getWindow(),
                                G = n.getWindow();
                        if (!F.equals(G) && F.$.frameElement) {
                            var H = new m(F.$.frameElement).ir(n);
                            o += H.x;
                            p += H.y;
                        }
                    }
                    if (!document.documentElement.getBoundingClientRect)
                        if (h.gecko && !r) {
                            o += I.$.clientLeft ? 1 : 0;
                            p += I.$.clientTop ? 1 : 0;
                        }
                    return {
                        x: o,
                        y: p
                    };
                },
                scrollIntoView: function(n) {
                    var t = this;
                    var o = t.getWindow(),
                            p = o.eR().height,
                            q = p * -1;
                    if (n)
                        q += p;
                    else {
                        q += t.$.offsetHeight || 0;
                        q += parseInt(t.getComputedStyle('marginBottom') || 0, 10) || 0;
                    }
                    var r = t.ir();
                    q += r.y;
                    q = q < 0 ? 0 : q;
                    var s = o.hV().y;
                    if (q > s || q < s - p)
                        o.$.scrollTo(0, q);
                },
                bR: function(n) {
                    var o = this;
                    switch (n) {
                        case a.eV:
                            o.addClass('cke_on');
                            o.removeClass('cke_off');
                            o.removeClass('cke_disabled');
                            break;
                        case a.aY:
                            o.addClass('cke_disabled');
                            o.removeClass('cke_off');
                            o.removeClass('cke_on');
                            break;
                        default:
                            o.addClass('cke_off');
                            o.removeClass('cke_on');
                            o.removeClass('cke_disabled');
                            break;
                    }
                },
                getFrameDocument: function() {
                    var n = this.$;
                    try {
                        n.contentWindow.document;
                    } catch (o) {
                        n.src = n.src;
                        if (i && h.version < 7)
                            window.showModalDialog('javascript:document.write("<script>window.setTimeout(function(){window.close();},50);</script>")');
                    }
                    return n && new l(n.contentWindow.document);
                },
                qw: function(n, o) {
                    var u = this;
                    var p = u.$.attributes;
                    o = o || {};
                    for (var q = 0; q < p.length; q++) {
                        var r = p[q];
                        if (r.specified || i && r.nodeValue && r.nodeName.toLowerCase() == 'value') {
                            var s = r.nodeName;
                            if (s in o)
                                continue;
                            var t = u.getAttribute(s);
                            if (t === null)
                                t = r.nodeValue;
                            n.setAttribute(s, t);
                        }
                    }
                    if (u.$.style.cssText !== '')
                        n.$.style.cssText = u.$.style.cssText;
                },
                renameNode: function(n) {
                    var q = this;
                    if (q.getName() == n)
                        return;
                    var o = q.getDocument(),
                            p = new m(n, o);
                    q.qw(p);
                    q.jg(p);
                    q.$.parentNode.replaceChild(p.$, q.$);
                    p.$._ckf_expando = q.$._ckf_expando;
                    q.$ = p.$;
                },
                getChild: function(n) {
                    var o = this.$;
                    if (!n.slice)
                        o = o.childNodes[n];
                    else
                        while (n.length > 0 && o)
                            o = o.childNodes[n.shift()];
                    return o ? new j.bi(o) : null;
                },
                iu: function() {
                    return this.$.childNodes.length;
                },
                hX: function() {
                    this.on('contextmenu', function(n) {
                        if (!n.data.bK().hasClass('cke_enable_context_menu'))
                            n.data.preventDefault();
                    });
                },
                'toString': function() {
                    return this.getName() + '#' + this.dS() + '.' + this.getAttribute('class');
                }
            });
            (function() {
                var n = {
                    width: ['border-left-width', 'border-right-width', 'padding-left', 'padding-right'],
                    height: ['border-top-width', 'border-bottom-width', 'padding-top', 'padding-bottom']
                };

                function o(p) {
                    var q = 0;
                    for (var r = 0, s = n[p].length; r < s; r++)
                        q += parseInt(this.getComputedStyle(n[p][r]) || 0, 10) || 0;
                    return q;
                }
                ;
                m.prototype.setSize = function(p, q, r) {
                    if (typeof q == 'number') {
                        if (r && !(i && h.quirks))
                            q -= o.call(this, p);
                        this.setStyle(p, q + 'px');
                    }
                };
                m.prototype.hR = function(p, q) {
                    var r = Math.max(this.$['offset' + k.capitalize(p)], this.$['client' + k.capitalize(p)]) || 0;
                    if (q)
                        r -= o.call(this, p);
                    return r;
                };
            })();
            a.command = function(n, o) {
                this.pW = [];
                this.exec = function(p) {
                    if (this.bu == a.aY || this.readOnly === false && n.config.readOnly)
                        return false;
                    if (o.oD)
                        n.focus();
                    return o.exec.call(this, n, p) !== false;
                };
                k.extend(this, o, {
                    iH: {
                        qt: 1
                    },
                    oD: true,
                    bu: a.aS
                });
                a.event.call(this);
            };
            a.command.prototype = {
                enable: function() {
                    var n = this;
                    if (n.bu == a.aY)
                        n.bR(!n.vf || typeof n.lJ == 'undefined' ? a.aS : n.lJ);
                },
                disable: function() {
                    this.bR(a.aY);
                },
                bR: function(n) {
                    var o = this;
                    if (o.bu == n)
                        return false;
                    o.lJ = o.bu;
                    o.bu = n;
                    o.oW('bu');
                    return true;
                },
                rJ: function() {
                    var n = this;
                    if (n.bu == a.aS)
                        n.bR(a.eV);
                    else if (n.bu == a.eV)
                        n.bR(a.aS);
                }
            };
            a.event.du(a.command.prototype, true);
            a.config = {
                customConfig: a.getUrl('config.js'),
                connectorLanguage: 'php',
                language: '',
                defaultLanguage: 'en',
                defaultViewType: 'thumbnails',
                defaultSortBy: 'filename',
                defaultDisplayFilename: true,
                defaultDisplayDate: true,
                defaultDisplayFilesize: true,
                pO: '',
                height: 400,
                plugins: 'foldertree,folder,filebrowser,container,connector,resource,search,toolbar,formpanel,filesview,status,contextmenu,uploadform,keystrokes,dragdrop,basket,dialog,tools,resize,maximize,help,flashupload,mobile,html5upload,gallery',
                extraPlugins: '',
                fileIcons: 'ai|avi|bmp|cs|dll|doc|docx|exe|fla|gif|jpg|js|mdb|mp3|ogg|pdf|ppt|pptx|rdp|swf|swt|txt|vsd|xls|xlsx|xml|zip',
                removePlugins: '',
                tabIndex: 0,
                thumbnailDelay: 50,
                theme: 'default',
                skin: 'kama',
                width: '100%',
                baseFloatZIndex: 10000,
                directDownload: false,
                log: false,
                logStackTrace: false,
                rememberLastFolder: true,
                id: null,
                startupPath: '',
                startupFolderExpanded: true,
                selectActionFunction: null,
                selectActionData: null,
                selectThumbnailActionFunction: null,
                selectThumbnailActionData: null,
                disableThumbnailSelection: false,
                thumbsUrl: null,
                thumbsDirectAccess: false,
                imagesMaxWidth: 0,
                imagesMaxHeight: 0,
                selectActionType: 'js',
                resourceType: null,
                disableHelpButton: false,
                connectorPath: '',
                connectorInfo: '',
                uiColor: null,
                showContextMenuArrow: false,
                useNativeIcons: false,
                maxSimultaneousUploads: 1,
                readOnly: false,
                selectMultiple: true
            };
            CKFinder.config = a.config;
            var n = a.config;
            a.dU = function(o, p) {
                this.rG = o;
                this.message = p;
            };
            a.fs = function(o) {
                if (o.fs)
                    return o.fs;
                this.hasFocus = false;
                this._ = {
                    application: o
                };
                return this;
            };
            a.fs.prototype = {
                focus: function() {
                    var p = this;
                    if (p._.fW)
                        clearTimeout(p._.fW);
                    if (!p.hasFocus) {
                        if (a.nG)
                            a.nG.fs.ly();
                        var o = p._.application;
                        o.container.getFirst().addClass('cke_focus');
                        p.hasFocus = true;
                        o.oW('focus');
                    }
                },
                blur: function() {
                    var o = this;
                    if (o._.fW)
                        clearTimeout(o._.fW);
                    o._.fW = setTimeout(function() {
                        delete o._.fW;
                        o.ly();
                    }, 100);
                },
                ly: function() {
                    if (this.hasFocus) {
                        var o = this._.application;
                        o.container.getFirst().removeClass('cke_focus');
                        this.hasFocus = false;
                        o.oW('blur');
                    }
                }
            };
            (function() {
                var o = {};
                a.lang = {
                    ko: {
                        bg: 1,
                        ca: 1,
                        cs: 1,
                        cy: 1,
                        da: 1,
                        de: 1,
                        el: 1,
                        en: 1,
                        eo: 1,
                        es: 1,
                        'es-mx': 1,
                        et: 1,
                        fa: 1,
                        fi: 1,
                        fr: 1,
                        gu: 1,
                        he: 1,
                        hi: 1,
                        hr: 1,
                        hu: 1,
                        it: 1,
                        ja: 1,
                        lv: 1,
                        lt: 1,
                        nb: 1,
                        nl: 1,
                        no: 1,
                        nn: 1,
                        pl: 1,
                        'pt-br': 1,
                        ro: 1,
                        ru: 1,
                        sk: 1,
                        sl: 1,
                        sr: 1,
                        sv: 1,
                        tr: 1,
                        vi: 1,
                        'zh-cn': 1,
                        'zh-tw': 1
                    },
                    load: function(p, q, r) {
                        if (!p || !a.lang.ko[p])
                            p = this.jV(q, p);
                        if (!this[p])
                            a.scriptLoader.load(a.getUrl('lang/' + p + '.js'), function() {
                                r(p, CKFinder.lang[p]);
                            }, this);
                        else
                            r(p, this[p]);
                    },
                    jV: function(p, q) {
                        var r = this.ko;
                        q = q || navigator.userLanguage || navigator.language;
                        var s = q.toLowerCase().match(/([a-z]+)(?:-([a-z]+))?/),
                                t = s[1],
                                u = s[2];
                        if (r[t + '-' + u])
                            t = t + '-' + u;
                        else if (!r[t])
                            t = null;
                        a.lang.jV = t ? function() {
                            return t;
                        } : function(v) {
                            return v;
                        };
                        return t || p;
                    }
                };
            })();
            (function() {
                a.log = function() {
                    if (!n.log && !window.CKFINDER_LOG)
                        return;
                    var o = '';
                    for (var p = 0; p < arguments.length; p++) {
                        var q = arguments[p];
                        if (!q)
                            continue;
                        if (o)
                            o += '; ';
                        switch (typeof q) {
                            case 'function':
                                var r = /function (\w+?)\(/.exec(q.toString());
                                r = r ? r[1] : 'anonymous func';
                                o += r;
                                break;
                            default:
                                o += q ? q.toString() : '';
                        }
                    }
                    a._.log.push(o);
                    if (typeof window.console == 'object')
                        if (!console.log.apply)
                            console.log(o);
                        else
                            console.log.apply(console, arguments);
                };
                a.ba = function(o) {
                    if (n.logStackTrace)
                        a.log('[EXCEPTION] ' + o.toString());
                    return o;
                };
                a.mZ = function(o) {
                    var p = '';
                    for (var q = 0; q < a._.log.length; q++)
                        p += q + 1 + '. ' + a._.log[q] + '\n';
                    return p;
                };
                a._.log = [];
            })();
            a.scriptLoader = (function() {
                var o = {}, p = {};
                return {
                    load: function(q, r, s, t, u) {
                        var v = typeof q == 'string';
                        if (v)
                            q = [q];
                        if (!s)
                            s = a;
                        var w = q.length,
                                x = [],
                                y = [],
                                z = function(F) {
                                    if (r)
                                        if (v)
                                            r.call(s, F);
                                        else
                                            r.call(s, x, y);
                                };
                        if (w === 0) {
                            z(true);
                            return;
                        }
                        var A = function(F, G) {
                            (G ? x : y).push(F);
                            if (--w <= 0)
                                z(G);
                        }, B = function(F, G) {
                            o[F] = 1;
                            var H = p[F];
                            delete p[F];
                            for (var I = 0; I < H.length; I++)
                                H[I](F, G);
                        }, C = function(F) {
                            if (t !== true && o[F]) {
                                A(F, true);
                                return;
                            }
                            var G = p[F] || (p[F] = []);
                            G.push(A);
                            if (G.length > 1)
                                return;
                            var H = new m('script');
                            H.setAttributes({
                                type: 'text/javascript',
                                src: F
                            });
                            if (r)
                                if (i)
                                    H.$.onreadystatechange = function() {
                                        if (H.$.readyState == 'loaded' || H.$.readyState == 'complete') {
                                            H.$.onreadystatechange = null;
                                            a.log('[LOADED] ' + F);
                                            B(F, true);
                                        }
                                    };
                                else {
                                    H.$.onload = function() {
                                        setTimeout(function() {
                                            a.log('[LOADED] ' + F);
                                            B(F, true);
                                        }, 0);
                                    };
                                    H.$.onerror = function() {
                                        B(F, false);
                                    };
                                }
                            H.appendTo(u ? u : a.document.getHead());
                        };
                        for (var D = 0, E = w; D < E; D++)
                            C(q[D]);
                    },
                    uq: function(q) {
                        var r = new m('script');
                        r.setAttribute('type', 'text/javascript');
                        r.appendText(q);
                        r.appendTo(a.document.getHead());
                    }
                };
            })();
            CKFinder.scriptLoader = a.scriptLoader;
            a.fQ = function(o, p) {
                var q = this;
                q.basePath = o;
                q.fileName = p;
                q.bX = {};
                q.loaded = {};
                q.jn = {};
                q._ = {
                    rZ: {}
                };
            };
            a.fQ.prototype = {
                add: function(o, p) {
                    if (this.bX[o])
                        throw '[CKFINDER.fQ.add] The resource name "' + o + '" is already bX.';
                    this.bX[o] = p || {};
                },
                eB: function(o) {
                    return this.bX[o] || null;
                },
                getPath: function(o) {
                    var p = this.jn[o];
                    return a.getUrl(p && p.dir || this.basePath + o + '/');
                },
                pi: function(o) {
                    var p = this.jn[o];
                    return a.getUrl(this.getPath(o) + (p && p.file || this.fileName + '.js'));
                },
                tR: function(o, p, q) {
                    o = o.split(',');
                    for (var r = 0; r < o.length; r++) {
                        var s = o[r];
                        this.jn[s] = {
                            dir: p,
                            file: q
                        };
                    }
                },
                load: function(o, p, q) {
                    if (!k.isArray(o))
                        o = o ? [o] : [];
                    var r = this.loaded,
                            s = this.bX,
                            t = [],
                            u = {}, v = {};
                    for (var w = 0; w < o.length; w++) {
                        var x = o[w];
                        if (!x)
                            continue;
                        if (!r[x] && !s[x]) {
                            var y = this.pi(x);
                            t.push(y);
                            if (!(y in u))
                                u[y] = [];
                            u[y].push(x);
                        } else
                            v[x] = this.eB(x);
                    }
                    a.scriptLoader.load(t, function(z, A) {
                        if (A.length)
                            throw '[CKFINDER.fQ.load] Resource name "' + u[A[0]].join(',') + '" was not found at "' + A[0] + '".';
                        for (var B = 0; B < z.length; B++) {
                            var C = u[z[B]];
                            for (var D = 0; D < C.length; D++) {
                                var E = C[D];
                                v[E] = this.eB(E);
                                r[E] = 1;
                            }
                        }
                        p.call(q, v);
                    }, this);
                }
            };
            a.plugins = new a.fQ('plugins/', 'plugin');
            var o = a.plugins;
            o.load = k.override(o.load, function(p) {
                return function(q, r, s) {
                    var t = {}, u = function(v) {
                        p.call(this, v, function(w) {
                            k.extend(t, w);
                            var x = [];
                            for (var y in w) {
                                var z = w[y],
                                        A = z && z.bM;
                                if (A)
                                    for (var B = 0; B < A.length; B++) {
                                        if (!t[A[B]])
                                            x.push(A[B]);
                                    }
                            }
                            if (x.length)
                                u.call(this, x);
                            else {
                                for (y in t) {
                                    z = t[y];
                                    if (z.onLoad && !z.onLoad.qK) {
                                        z.onLoad();
                                        z.onLoad.qK = 1;
                                    }
                                }
                                if (r)
                                    r.call(s || window, t);
                            }
                        }, this);
                    };
                    u.call(this, q);
                };
            });
            o.rX = function(p, q, r) {
                var s = this.eB(p);
                s.lang[q] = r;
            };
            (function() {
                var p = {}, q = function(r, s) {
                    var t = function() {
                        p[r] = 1;
                        s();
                    }, u = new m('img');
                    u.on('load', t);
                    u.on('error', t);
                    u.setAttribute('src', r);
                };
                a.rw = {
                    load: function(r, s) {
                        var t = r.length,
                                u = function() {
                                    if (--t === 0)
                                        s();
                                };
                        for (var v = 0; v < r.length; v++) {
                            var w = r[v];
                            if (p[w])
                                u();
                            else
                                q(w, u);
                        }
                    }
                };
            })();
            a.skins = (function() {
                var p = {}, q = {}, r = {}, s = function(t, u, v, w) {
                    var x = p[u];
                    if (!t.skin) {
                        t.skin = x;
                        if (x.bz)
                            x.bz(t);
                    }
                    var y = function(G) {
                        for (var H = 0; H < G.length; H++)
                            G[H] = a.getUrl(r[u] + G[H]);
                    };
                    if (!q[u]) {
                        var z = x.ls;
                        if (z && z.length > 0) {
                            y(z);
                            a.rw.load(z, function() {
                                q[u] = 1;
                                s(t, u, v, w);
                            });
                            return;
                        }
                        q[u] = 1;
                    }
                    v = x[v];
                    var A = 0;
                    if (v) {
                        if (!v.iB)
                            v.iB = [];
                        else if (v.iB[t.name])
                            A = 1;
                    } else
                        A = 1;
                    if (A)
                        w && w();
                    else {
                        if (v.eb === undefined)
                            v.eb = [];
                        if (v.eb[t.name] === undefined)
                            v.eb[t.name] = [];
                        var B = v.eb[t.name];
                        B.push(w);
                        if (B.length > 1)
                            return;
                        var C = !v.css || !v.css.length,
                                D = !v.js || !v.js.length,
                                E = function() {
                                    if (C && D) {
                                        v.iB[t.name] = 1;
                                        for (var G = 0; G < B.length; G++) {
                                            if (B[G])
                                                B[G]();
                                        }
                                    }
                                };
                        if (!C) {
                            if (!v.rr) {
                                y(v.css);
                                v.rr = 1;
                            }
                            if (v.qx)
                                for (var F = 0; F < v.css.length; F++)
                                    a.oC.appendStyleSheet(v.css[F]);
                            else
                                t.on('themeSpace', function(G) {
                                    if (G.data.space == 'head')
                                        for (var H = 0; H < v.css.length; H++)
                                            G.data.html += "<link rel='stylesheet' href='" + v.css[H] + "'>\n";
                                    G.removeListener();
                                });
                            C = 1;
                        }
                        if (!D) {
                            y(v.js);
                            t.scriptLoader.load(v.js, function() {
                                D = 1;
                                E();
                            });
                        }
                        E();
                    }
                };
                return {
                    add: function(t, u) {
                        p[t] = u;
                        u.fh = r[t] || (r[t] = a.getUrl('skins/' + t + '/'));
                    },
                    loaded: p,
                    load: function(t, u, v) {
                        var w = t.gd,
                                x = t.fh;
                        if (p[w]) {
                            s(t, w, u, v);
                            var y = p[w];
                        } else {
                            r[w] = x;
                            a.scriptLoader.load(x + 'skin.js', function() {
                                s(t, w, u, v);
                            });
                        }
                    }
                };
            })();
            a.gc = new a.fQ('gc/', 'theme');
            a.bY = function(p) {
                if (p.bY)
                    return p.bY;
                this._ = {
                    jZ: {},
                    items: {},
                    application: p
                };
                return this;
            };
            var p = a.bY;
            p.prototype = {
                add: function(q, r, s) {
                    this._.items[q] = {
                        type: r,
                        command: s.command || null,
                        mp: Array.prototype.slice.call(arguments, 2)
                    };
                },
                create: function(q) {
                    var v = this;
                    var r = v._.items[q],
                            s = r && v._.jZ[r.type],
                            t = r && r.command && v._.application.cS(r.command),
                            u = s && s.create.apply(v, r.mp);
                    if (t)
                        t.pW.push(u);
                    return u;
                },
                kd: function(q, r) {
                    this._.jZ[q] = r;
                }
            };
            (function() {
                var q = 0,
                        r = function() {
                            var D = 'ckfinder' + ++q;
                            return a.instances && a.instances[D] ? r() : D;
                        }, s = {}, t = function(D) {
                    var E = D.config.customConfig;
                    if (!E)
                        return false;
                    var F = s[E] || (s[E] = {});
                    if (F.fn) {
                        F.fn.call(D, D.config);
                        if (D.config.customConfig == E || !t(D))
                            D.cr('customConfigLoaded');
                    } else
                        a.scriptLoader.load(E, function() {
                            if (CKFinder.customConfig)
                                F.fn = CKFinder.customConfig;
                            else
                                F.fn = function() {
                                };
                            t(D);
                        });
                    return true;
                }, u = function(D, E) {
                    D.on('customConfigLoaded', function() {
                        if (E) {
                            if (E.on)
                                for (var F in E.on)
                                    D.on(F, E.on[F]);
                            k.extend(D.config, E, true);
                            delete D.config.on;
                        }
                        v(D);
                    });
                    if (E && E.id)
                        D.config.id = E.id;
                    if (E && E.customConfig != undefined)
                        D.config.customConfig = E.customConfig;
                    if (!t(D))
                        D.cr('customConfigLoaded');
                }, v = function(D) {
                    var E = D.config.skin.split(','),
                            F = E[0],
                            G = a.getUrl(E[1] || 'skins/' + F + '/');
                    D.gd = F;
                    D.fh = G;
                    D.iy = 'cke_skin_' + F + ' skin_' + F;
                    D.qn = D.ox();
                    D.on('uiReady', function() {
                        D.document.getWindow().on('lW', function() {
                            k.setCookie('CKFinder_UTime', Math.round(new Date().getTime() / 1000), true);
                            k.setCookie('CKFinder_UId', encodeURIComponent(D.id ? D.id : location.href), true);
                        });
                    });
                    D.cr('configLoaded');
                    z(D);
                }, w = function(D, E) {
                    a.event.jP = true;
                    D.document.on('keydown', function(F) {
                        var G = F.data,
                                H = G.oV(),
                                I = G.db();
                        if (H == 116 || I == a.bP + 82 || I == a.bP + a.dy + 82) {
                            D.execCommand('refresh');
                            E.$.event && E.$.event.keyCode && (E.$.event.keyCode = 5055);
                            try {
                                F.data.preventDefault();
                            } catch (F) {
                            }
                        }
                    });
                    a.event.jP = false;
                }, x = function(D, E, F) {
                    var G = [],
                            H, I;
                    for (I = 0; I < F.length; I++) {
                        H = F[I];
                        G.push({
                            evt: 'onbeforeunload',
                            bi: H.bH().$,
                            fO: H.bH().$.onbeforeunload
                        }, {
                            evt: 'onunload',
                            bi: H.getWindow().$,
                            fO: H.getWindow().$.onunload
                        }, {
                            evt: 'onbeforeunload',
                            bi: H.getWindow().$,
                            fO: H.getWindow().$.onbeforeunload
                        });
                    }
                    E.$.onunload = E.$.onbeforeunload = function() {
                        var J;
                        for (J = 0; J < G.length; J += 1)
                            G[J].bi[G[J].evt] = G[J].fO;
                    };
                }, y = function(D, E) {
                    var F = [a.oC],
                            G, H = E.$.top.location.href.match(/ckfinder.html/) || E.$.top.name == 'CKFinderpopup';
                    if (!H)
                        return;
                    D.document.focus();
                    D.focus();
                    if (D.cg.inUrlPopup)
                        try {
                            F.push(new l(a.oC.getWindow().$.opener.document));
                        } catch (I) {
                        }
                    w(D, E);
                    x(D, E, F);
                    for (G = 0; G < F.length; G += 1)
                        F[G].bH().$.onbeforeunload = F[G].getWindow().$.onunload = F[G].getWindow().$.onbeforeunload = function() {
                            var J = D.element && D.element.getDocument().getWindow().$;
                            if (!J.closed)
                                J.close();
                        };
                }, z = function(D) {
                    a.lang.load(D.config.language, D.config.defaultLanguage, function(E, F) {
                        D.langCode = E;
                        D.lang = k.prototypedCopy(F);
                        D.lB = (function() {
                            var G = "['" + D.lang.DateAmPm.join("','") + "']",
                                    H = D.lang.DateTime.replace(/dd|mm|yyyy|hh|HH|MM|aa|d|m|yy|h|H|M|a/g, function(I) {
                                        var J;
                                        switch (I) {
                                            case 'd':
                                                J = "day.replace(/^0/,'')";
                                                break;
                                            case 'dd':
                                                J = 'day';
                                                break;
                                            case 'm':
                                                J = "month.replace(/^0/,'')";
                                                break;
                                            case 'mm':
                                                J = 'month';
                                                break;
                                            case 'yy':
                                                J = 'year.substr(2)';
                                                break;
                                            case 'yyyy':
                                                J = 'year';
                                                break;
                                            case 'H':
                                                J = "hour.replace(/^0/,'')";
                                                break;
                                            case 'HH':
                                                J = 'hour';
                                                break;
                                            case 'h':
                                                J = "( hour < 12 ? hour : ( ( hour - 12 ) + 100 ).toString().substr( 1 ) ).replace(/^0/,'')";
                                                break;
                                            case 'hh':
                                                J = '( hour < 12 ? hour : ( ( hour - 12 ) + 100 ).toString().substr( 1 ) )';
                                                break;
                                            case 'M':
                                                J = "minute.replace(/^0/,'')";
                                                break;
                                            case 'MM':
                                                J = 'minute';
                                                break;
                                            case 'a':
                                                J = G + '[ hour < 12 ? 0 : 1 ].charAt(0)';
                                                break;
                                            case 'aa':
                                                J = G + '[ hour < 12 ? 0 : 1 ]';
                                                break;
                                            default:
                                                J = "'" + I + "'";
                                        }
                                        return "'," + J + ",'";
                                    });
                            H = "'" + H + "'";
                            H = H.replace(/('',)|,''$/g, '');
                            return new Function('day', 'month', 'year', 'hour', 'minute', 'return [' + H + "].join('');");
                        })();
                        if (h.gecko && h.version < 10900 && D.lang.dir == 'rtl')
                            D.lang.dir = 'ltr';
                        A(D);
                    });
                }, A = function(D) {
                    var E = D.config,
                            F = E.plugins,
                            G = E.extraPlugins,
                            H = E.removePlugins;
                    if (G) {
                        var I = new RegExp('(?:^|,)(?:' + G.replace(/\s*,\s*/g, '|') + ')(?=,|$)', 'g');
                        F = F.replace(I, '');
                        F += ',' + G;
                    }
                    if (H) {
                        I = new RegExp('(?:^|,)(?:' + H.replace(/\s*,\s*/g, '|') + ')(?=,|$)', 'g');
                        F = F.replace(I, '');
                    }
                    o.load(F.split(','), function(J) {
                        var K = [],
                                L = [],
                                M = [],
                                N;
                        if (D.config.readOnly)
                            for (var N in J) {
                                if (J[N].readOnly === false)
                                    delete J[N];
                            }
                        D.plugins = J;
                        for (N in J) {
                            var O = J[N],
                                    P = O.lang,
                                    Q = o.getPath(N),
                                    R = null;
                            J[N].name = N;
                            O.pathName = Q;
                            if (P) {
                                R = k.indexOf(P, D.langCode) >= 0 ? D.langCode : P[0];
                                if (!O.lang[R])
                                    M.push(a.getUrl(Q + 'lang/' + R + '.js'));
                                else {
                                    k.extend(D.lang, O.lang[R]);
                                    R = null;
                                }
                            }
                            L.push(R);
                            K.push(O);
                        }
                        a.scriptLoader.load(M, function() {
                            var S = ['eK', 'bz', 'gr'];
                            for (var T = 0; T < S.length; T++)
                                for (var U = 0; U < K.length; U++) {
                                    var V = K[U];
                                    if (T === 0 && L[U] && V.lang)
                                        k.extend(D.lang, V.lang[L[U]]);
                                    if (V[S[T]]) {
                                        a.log('[PLUGIN] ' + V.name + '.' + S[T]);
                                        V[S[T]](D);
                                    }
                                }
                            D.oW('pluginsLoaded');
                            B(D);
                        });
                    });
                }, B = function(D) {
                    a.skins.load(D, 'application', function() {
                        a.skins.load(D, 'host', function() {
                            C(D);
                        });
                    });
                }, C = function(D) {
                    var E = D.config.theme;
                    a.gc.load(E, function() {
                        var F = D.theme = a.gc.eB(E);
                        F.pathName = a.gc.getPath(E);
                        D.oW('themeAvailable');
                    });
                };
                a.application.prototype.iI = function(D) {
                    var E = m.eB(this._.element),
                            F = this._.instanceConfig;
                    delete this._.element;
                    delete this._.instanceConfig;
                    this._.ky = {};
                    this._.gS = [];
                    E.getDocument().getWindow().$.CKFinder = D;
                    this.element = E;
                    this.document = null;
                    this.rQ = {};
                    this.name = r();
                    if (this.name in a.instances)
                        throw '[CKFINDER.application] The instance "' + this.name + '" already exists.';
                    this.config = k.prototypedCopy(n);
                    this.bY = new p(this);
                    this.fs = new a.fs(this);
                    this.aL = {};
                    this.ld = {};
                    this.on('uiReady', function(G) {
                        var I = this;
                        var H = I.document.getWindow();
                        H.on('lW', I.destroy, I);
                        if (I.cg.inPopup)
                            y(I, H);
                    }, this);
                    this.cg = new d(this);
                    this.on('configLoaded', function(G) {
                        var H = this;
                        e(H.cg, H, H.config.callback);
                        H.id = H.config.id;
                    }, this);
                    u(this, F);
                    a.oW('instanceCreated', null, this);
                };
            })();
            k.extend(a.application.prototype, {
                bD: function(q, r) {
                    return this._.ky[q] = new a.command(this, r);
                },
                destroy: function() {
                    var q = this;
                    q.theme.destroy(q);
                    q.oW('destroy');
                    a.remove(q);
                },
                execCommand: function(q, r) {
                    a.log('[COMMAND] ' + q);
                    var s = this.cS(q),
                            t = {
                                name: q,
                                rm: r,
                                command: s
                            };
                    if (s && s.bu != a.aY)
                        if (this.oW('beforeCommandExec', t) !== true) {
                            t.returnValue = s.exec(t.rm);
                            if (!s.async && this.oW('afterCommandExec', t) !== true)
                                return t.returnValue;
                        }
                    return false;
                },
                cS: function(q) {
                    return this._.ky[q];
                },
                ox: function() {
                    var q = Math.round(new Date().getTime() / 1000),
                            r = k.getCookie('CKFinder_UTime'),
                            s = decodeURIComponent(k.getCookie('CKFinder_UId'));
                    if (s && r && s == (this.id ? this.id : location.href) && Math.abs(q - r) < 5)
                        return 1;
                    return 0;
                },
                bs: ''
            });
            (function() {
                var q = '';
                for (var r = 49; r < 58; r++)
                    q += String.fromCharCode(r);
                for (r = 65; r < 91; r++) {
                    if (r == 73 || r == 79)
                        continue;
                    q += String.fromCharCode(r);
                }
                a.bs = q;
                a.nd = "l\157";
                a.jG = "\150o";
                a.hf = new window["Re\147\105x\160"]("\136\167ww\134.");
                a.hg = new window["Re\147\105xp"](":\\\144+\044");
                a.lS = function(s) {
                    return s.toLowerCase().replace(a.hf, '').replace(a.hg, '');
                };
            })();
            a.on('loaded', function() {
                var q = a.application.eb;
                if (q) {
                    delete a.application.eb;
                    for (var r = 0; r < q.length; r++)
                        q[r].iI();
                }
            });
            delete a.dO;
            a.instances = {};
            a.document = new l(document);
            a.oC = a.document.getWindow().$ != a.document.getWindow().$.top ? new l(a.document.getWindow().$.top.document) : a.document;
            a.add = function(q) {
                a.instances[q.name] = q;
                a.jt = q;
                q.on('focus', function() {
                    if (a.nG != q) {
                        a.nG = q;
                        a.oW('nG');
                    }
                });
                q.on('blur', function() {
                    if (a.nG == q) {
                        a.nG = null;
                        a.oW('nG');
                    }
                });
            };
            a.remove = function(q) {
                delete a.instances[q.name];
            };
            a.aL = {};
            a.eV = 1;
            a.aS = 2;
            a.aY = 0;
            a.bF = '';
            (function() {
                function q(t, u) {
                    return t + '.' + (u.name || u || t);
                }
                ;
                a.ld = {
                    bX: {},
                    hS: function(t, u, v) {
                        var w = q(t, u);
                        if (this.bX[w] !== undefined)
                            throw '[CKFINDER] Widget ' + w + ' already bX!';
                        a.log('[WIDGET] bX ' + w);
                        this.bX[w] = new s(w, v);
                        return this.bX[w];
                    },
                    bz: function(t, u, v, w, x) {
                        var y = q(u, v),
                                z = this.bX[y],
                                A = k.deepCopy(z.hF),
                                B = function(E, F, G) {
                                    this.app = E;
                                    this.eh = F instanceof m ? F : new m(F);
                                    this.hF = A ? k.extend(A, G) : G || {};
                                    this._ = {};
                                    var H = function(K) {
                                        this.ib = K;
                                    };
                                    H.prototype = this.tools;
                                    this.tools = new H(this);
                                    var I = z.dT;
                                    if (I.length)
                                        for (var J = 0; J < I.length; J++)
                                            I[J].call(this, E, this);
                                };
                        B.prototype = z;
                        var C = new B(t, w, x);
                        for (var D in C.fw) {
                            if (C.fw[D].readOnly && t.config.readOnly)
                                C.ke(D);
                            else
                                C.gA(D);
                        }
                        if (t.ld[y])
                            throw '[CKFINDER Widget ' + y + ' already inited.';
                        t.ld[y] = C;
                        a.log('[WIDGET] instanced ' + y);
                        return C;
                    }
                };
                var r = {
                    click: 1,
                    mouseover: 1,
                    mouseout: 1,
                    focus: 1,
                    blur: 1,
                    submit: 1,
                    dblclick: 1,
                    mousedown: 1,
                    mouseup: 1,
                    mousemove: 1,
                    keypress: 1,
                    keydown: 1,
                    keyup: 1,
                    load: 1,
                    lW: 1,
                    abort: 1,
                    error: 1,
                    resize: 1,
                    scroll: 1,
                    select: 1,
                    change: 1,
                    reset: 1
                }, s = function(t, u) {
                    var v = this;
                    v.id = t;
                    v.readOnly = true;
                    v.fw = {};
                    v.hF = u || {};
                    v.dT = [];
                    v.tools = new v.tools(v);
                };
                s.prototype = {
                    gA: function(t) {
                        var y = this;
                        a.log('[WIDGET] Enabling behavior ' + t);
                        var u = y.fw[t];
                        if (!u)
                            return;
                        var v = y;
                        for (var w = 0; w < u.cC.length; w++) {
                            var x = u.cC[w];
                            if (r[x])
                                y.eh.on(x, u.fO, v);
                            else {
                                y.on(x, u.fO, v);
                                y.app.on(x, u.fO, v);
                            }
                        }
                    },
                    ke: function(t) {
                        a.log('[WIDGET] Disabling behavior ' + t);
                        var u = this.fw[t];
                        if (!u)
                            return;
                        for (var v = 0; v < u.cC.length; v++) {
                            var w = u.cC[v];
                            if (r[w])
                                this.eh.removeListener(w, u.fO);
                            else
                                this.removeListener(w, u.fO);
                        }
                    },
                    bh: function(t, u, v, w) {
                        if (!k.isArray(u))
                            u = [u];
                        this.fw[t] = {
                            cC: u,
                            fO: v,
                            readOnly: w === false
                        };
                        if (this.eh)
                            this.gA(t);
                    },
                    removeBehavior: function(t) {
                        delete this.fw[t];
                    },
                    ur: function() {
                        return this.fw;
                    },
                    bn: function() {
                        return this.eh;
                    },
                    oE: function() {
                        return this.hF;
                    },
                    data: function() {
                        return this.hF;
                    },
                    tools: function() {
                    }
                };
                s.prototype.tools.prototype = {
                    kg: function(t) {
                        if (t.target == this.ib.eh)
                            return 1;
                    }
                };
                a.event.du(s.prototype);
            })();
            a.xml = function(q) {
                var r = null;
                if (typeof q == 'object')
                    r = q;
                else {
                    var s = (q || '').replace(/&nbsp;/g, '\xa0');
                    if (window.DOMParser)
                        r = new DOMParser().parseFromString(s, 'text/xml');
                    else if (window.ActiveXObject) {
                        try {
                            r = new ActiveXObject('MSXML2.DOMDocument');
                        } catch (t) {
                            try {
                                r = new ActiveXObject('Microsoft.XmlDom');
                            } catch (t) {
                            }
                        }
                        if (r) {
                            r.async = false;
                            r.resolveExternals = false;
                            r.validateOnParse = false;
                            r.loadXML(s);
                        }
                    }
                }
                this.mq = r;
            };
            a.xml.prototype = {
                selectSingleNode: function(q, r) {
                    var s = this.mq;
                    if (r || (r = s))
                        if ('selectSingleNode' in r)
                            return r.selectSingleNode(q);
                        else if (s.evaluate) {
                            var t = s.evaluate(q, r, null, 9, null);
                            return t && t.singleNodeValue || null;
                        } else if (r.querySelectorAll) {
                            var u = this.selectNodes(q, r);
                            if (u.length == 1) {
                                var t = q.match(/\/@(.*$)/);
                                if (t)
                                    return u[0].getAttributeNode(t[1]);
                                else
                                    return u[0];
                            }
                        } else
                            alert('XPath is not supported in your browser');
                    return null;
                },
                selectNodes: function(q, r) {
                    var s = this.mq,
                            t = [];
                    if (r || (r = s))
                        if ('selectNodes' in r)
                            return r.selectNodes(q);
                        else if (s.evaluate) {
                            var u = s.evaluate(q, r, null, 5, null);
                            if (u) {
                                var v;
                                while (v = u.iterateNext())
                                    t.push(v);
                            }
                        } else if (r.querySelectorAll) {
                            var w = q.replace(/\/@(.*$)/, '[$1]').replace(/\//gi, '>');
                            return r.querySelectorAll(w);
                        } else
                            alert('XPath is not supported in your browser');
                    return t;
                },
                vB: function(q, r) {
                    var s = this.selectSingleNode(q, r),
                            t = [];
                    if (s) {
                        s = s.firstChild;
                        while (s) {
                            if (s.xml)
                                t.push(s.xml);
                            else if (window.XMLSerializer)
                                t.push(new XMLSerializer().serializeToString(s));
                            s = s.nextSibling;
                        }
                    }
                    return t.length ? t.join('') : null;
                }
            };
            (function() {
                var q = {
                    address: 1,
                    tY: 1,
                    dl: 1,
                    h1: 1,
                    h2: 1,
                    h3: 1,
                    h4: 1,
                    h5: 1,
                    h6: 1,
                    p: 1,
                    pre: 1,
                    li: 1,
                    dt: 1,
                    de: 1
                }, r = {
                    body: 1,
                    div: 1,
                    table: 1,
                    tbody: 1,
                    tr: 1,
                    td: 1,
                    th: 1,
                    caption: 1,
                    form: 1
                }, s = function(t) {
                    var u = t.getChildren();
                    for (var v = 0, w = u.count(); v < w; v++) {
                        var x = u.getItem(v);
                        if (x.type == a.cv && a.ga.um[x.getName()])
                            return true;
                    }
                    return false;
                };
                j.qS = function(t) {
                    var z = this;
                    var u = null,
                            v = null,
                            w = [],
                            x = t;
                    while (x) {
                        if (x.type == a.cv) {
                            if (!z.qH)
                                z.qH = x;
                            var y = x.getName();
                            if (i && x.$.scopeName != 'HTML')
                                y = x.$.scopeName.toLowerCase() + ':' + y;
                            if (!v) {
                                if (!u && q[y])
                                    u = x;
                                if (r[y])
                                    if (!u && y == 'div' && !s(x))
                                        u = x;
                                    else
                                        v = x;
                            }
                            w.push(x);
                            if (y == 'body')
                                break;
                        }
                        x = x.getParent();
                    }
                    z.block = u;
                    z.tX = v;
                    z.elements = w;
                };
            })();
            j.qS.prototype = {
                sJ: function(q) {
                    var r = this.elements,
                            s = q && q.elements;
                    if (!s || r.length != s.length)
                        return false;
                    for (var t = 0; t < r.length; t++) {
                        if (!r[t].equals(s[t]))
                            return false;
                    }
                    return true;
                }
            };
            j.text = function(q, r) {
                if (typeof q == 'string')
                    q = (r ? r.$ : document).createTextNode(q);
                this.$ = q;
            };
            j.text.prototype = new j.bi();
            k.extend(j.text.prototype, {
                type: a.fl,
                hJ: function() {
                    return this.$.nodeValue.length;
                },
                getText: function() {
                    return this.$.nodeValue;
                },
                split: function(q) {
                    var v = this;
                    if (i && q == v.hJ()) {
                        var r = v.getDocument().jT('');
                        r.kB(v);
                        return r;
                    }
                    var s = v.getDocument(),
                            t = new j.text(v.$.splitText(q), s);
                    if (h.ie8) {
                        var u = new j.text('', s);
                        u.kB(t);
                        u.remove();
                    }
                    return t;
                },
                substring: function(q, r) {
                    if (typeof r != 'number')
                        return this.$.nodeValue.substr(q);
                    else
                        return this.$.nodeValue.substring(q, r);
                }
            });
            j.pa = function(q) {
                q = q || a.document;
                this.$ = q.$.createDocumentFragment();
            };
            k.extend(j.pa.prototype, m.prototype, {
                type: a.om,
                kA: function(q) {
                    q = q.$;
                    q.parentNode.insertBefore(this.$, q.nextSibling);
                }
            }, true, {
                append: 1,
                pd: 1,
                getFirst: 1,
                dB: 1,
                appendTo: 1,
                jg: 1,
                insertBefore: 1,
                kA: 1,
                replace: 1,
                trim: 1,
                type: 1,
                ltrim: 1,
                rtrim: 1,
                getDocument: 1,
                iu: 1,
                getChild: 1,
                getChildren: 1
            });
            (function() {
                function q(u, v) {
                    if (this._.end)
                        return null;
                    var w, x = this.mk,
                            y, z = this.vR,
                            A = this.type,
                            B = u ? 'getPreviousSourceNode' : 'getNextSourceNode';
                    if (!this._.start) {
                        this._.start = 1;
                        x.trim();
                        if (x.collapsed) {
                            this.end();
                            return null;
                        }
                    }
                    if (!u && !this._.kp) {
                        var C = x.endContainer,
                                D = C.getChild(x.endOffset);
                        this._.kp = function(H, I) {
                            return (!I || !C.equals(H)) && (!D || !H.equals(D)) && (H.type != a.cv || H.getName() != 'body');
                        };
                    }
                    if (u && !this._.ka) {
                        var E = x.startContainer,
                                F = x.startOffset > 0 && E.getChild(x.startOffset - 1);
                        this._.ka = function(H, I) {
                            return (!I || !E.equals(H)) && (!F || !H.equals(F)) && (H.type != a.cv || H.getName() != 'body');
                        };
                    }
                    var G = u ? this._.ka : this._.kp;
                    if (z)
                        y = function(H, I) {
                            if (G(H, I) === false)
                                return false;
                            return z(H);
                        };
                    else
                        y = G;
                    if (this.current)
                        w = this.current[B](false, A, y);
                    else if (u) {
                        w = x.endContainer;
                        if (x.endOffset > 0) {
                            w = w.getChild(x.endOffset - 1);
                            if (y(w) === false)
                                w = null;
                        } else
                            w = y(w) === false ? null : w.hZ(true, A, y);
                    } else {
                        w = x.startContainer;
                        w = w.getChild(x.startOffset);
                        if (w) {
                            if (y(w) === false)
                                w = null;
                        } else
                            w = y(x.startContainer) === false ? null : x.startContainer.hL(true, A, y);
                    }
                    while (w && !this._.end) {
                        this.current = w;
                        if (!this.lf || this.lf(w) !== false) {
                            if (!v)
                                return w;
                        } else if (v && this.lf)
                            return false;
                        w = w[B](false, A, y);
                    }
                    this.end();
                    return this.current = null;
                }
                ;

                function r(u) {
                    var v, w = null;
                    while (v = q.call(this, u))
                        w = v;
                    return w;
                }
                ;
                j.gm = k.createClass({
                    $: function(u) {
                        this.mk = u;
                        this._ = {};
                    },
                    ej: {
                        end: function() {
                            this._.end = 1;
                        },
                        next: function() {
                            return q.call(this);
                        },
                        previous: function() {
                            return q.call(this, true);
                        },
                        sC: function() {
                            return q.call(this, false, true) !== false;
                        },
                        sD: function() {
                            return q.call(this, true, true) !== false;
                        },
                        uF: function() {
                            return r.call(this);
                        },
                        uB: function() {
                            return r.call(this, true);
                        },
                        reset: function() {
                            delete this.current;
                            this._ = {};
                        }
                    }
                });
                var s = {
                    block: 1,
                    'list-item': 1,
                    table: 1,
                    'table-row-group': 1,
                    'table-header-group': 1,
                    'table-footer-group': 1,
                    'table-row': 1,
                    'table-column-group': 1,
                    'table-column': 1,
                    'table-cell': 1,
                    'table-caption': 1
                }, t = {
                    hr: 1
                };
                m.prototype.qy = function(u) {
                    var v = k.extend({}, t, u || {});
                    return s[this.getComputedStyle('display')] || v[this.getName()];
                };
                j.gm.pQ = function(u) {
                    return function(v, w) {
                        return !(v.type == a.cv && v.qy(u));
                    };
                };
                j.gm.us = function() {
                    return this.pQ({
                        br: 1
                    });
                };
                j.gm.tU = function(u) {
                }, j.gm.tW = function(u, v) {
                    function w(x) {
                        return x && x.getName && x.getName() == 'span' && x.hasAttribute('_fck_bookmark');
                    }
                    ;
                    return function(x) {
                        var y, z;
                        y = x && !x.getName && (z = x.getParent()) && w(z);
                        y = u ? y : y || w(x);
                        return v ^ y;
                    };
                };
                j.gm.sf = function(u) {
                    return function(v) {
                        var w = v && v.type == a.fl && !k.trim(v.getText());
                        return u ^ w;
                    };
                };
            })();
            (function() {
                if (h.webkit) {
                    h.hc = false;
                    return;
                }
                var q = m.kE('<div style="width:0px;height:0px;position:absolute;left:-10000px;border:1px solid;border-color:red blue;"></div>', a.document);
                q.appendTo(a.document.getHead());
                try {
                    h.hc = q.getComputedStyle('border-top-color') == q.getComputedStyle('border-right-color');
                } catch (r) {
                    h.hc = false;
                }
                if (h.hc)
                    h.cssClass += ' cke_hc';
                q.remove();
            })();
            o.load(n.pO.split(','), function() {
                a.status = 'loaded';
                a.oW('loaded');
                var q = a._.io;
                if (q) {
                    delete a._.io;
                    for (var r = 0; r < q.length; r++)
                        a.add(q[r]);
                }
            });
            if (i)
                try {
                    document.execCommand('BackgroundImageCache', false, true);
                } catch (q) {
                }
            CKFinder.lang.en = {
                appTitle: 'CKFinder',
                common: {
                    unavailable: '%1<span class="cke_accessibility">, unavailable</span>',
                    confirmCancel: 'Some of the options were changed. Are you sure you want to close the dialog window?',
                    ok: 'OK',
                    cancel: 'Cancel',
                    confirmationTitle: 'Confirmation',
                    messageTitle: 'Information',
                    inputTitle: 'Question',
                    undo: 'Undo',
                    redo: 'Redo',
                    skip: 'Skip',
                    skipAll: 'Skip all',
                    makeDecision: 'What action should be taken?',
                    rememberDecision: 'Remember my decision'
                },
                dir: 'ltr',
                HelpLang: 'en',
                LangCode: 'en',
                DateTime: 'm/d/yyyy h:MM aa',
                DateAmPm: ['AM', 'PM'],
                FoldersTitle: 'Folders',
                FolderLoading: 'Loading...',
                FolderNew: 'Please type the new folder name: ',
                FolderRename: 'Please type the new folder name: ',
                FolderDelete: 'Are you sure you want to delete the "%1" folder?',
                FolderRenaming: ' (Renaming...)',
                FolderDeleting: ' (Deleting...)',
                DestinationFolder: 'Destination Folder',
                FileRename: 'Please type the new file name: ',
                FileRenameExt: 'Are you sure you want to change the file extension? The file may become unusable.',
                FileRenaming: 'Renaming...',
                FileDelete: 'Are you sure you want to delete the file "%1"?',
                FilesDelete: 'Are you sure you want to delete %1 files?',
                FilesLoading: 'Loading...',
                FilesEmpty: 'The folder is empty.',
                DestinationFile: 'Destination File',
                SkippedFiles: 'List of skipped files:',
                BasketFolder: 'Basket',
                BasketClear: 'Clear Basket',
                BasketRemove: 'Remove from Basket',
                BasketOpenFolder: 'Open Parent Folder',
                BasketTruncateConfirm: 'Do you really want to remove all files from the basket?',
                BasketRemoveConfirm: 'Do you really want to remove the file "%1" from the basket?',
                BasketRemoveConfirmMultiple: 'Do you really want to remove %1 files from the basket?',
                BasketEmpty: 'No files in the basket, drag and drop some.',
                BasketCopyFilesHere: 'Copy Files from Basket',
                BasketMoveFilesHere: 'Move Files from Basket',
                OperationCompletedSuccess: 'Operation completed successfully.',
                OperationCompletedErrors: 'Operation completed with errors.',
                FileError: '%s: %e',
                MovedFilesNumber: 'Number of files moved: %s.',
                CopiedFilesNumber: 'Number of files copied: %s.',
                MoveFailedList: 'The following files could not be moved:<br />%s',
                CopyFailedList: 'The following files could not be copied:<br />%s',
                Upload: 'Upload',
                UploadTip: 'Upload New File',
                Refresh: 'Refresh',
                Settings: 'Settings',
                Help: 'Help',
                HelpTip: 'Help',
                Select: 'Select',
                SelectThumbnail: 'Select Thumbnail',
                View: 'View',
                Download: 'Download',
                NewSubFolder: 'New Subfolder',
                Rename: 'Rename',
                Delete: 'Delete',
                DeleteFiles: 'Delete Files',
                CopyDragDrop: 'Copy Here',
                MoveDragDrop: 'Move Here',
                RenameDlgTitle: 'Rename',
                NewNameDlgTitle: 'New Name',
                FileExistsDlgTitle: 'File Already Exists',
                SysErrorDlgTitle: 'System Error',
                FileOverwrite: 'Overwrite',
                FileAutorename: 'Auto-rename',
                ManuallyRename: 'Manually rename',
                OkBtn: 'OK',
                CancelBtn: 'Cancel',
                CloseBtn: 'Close',
                UploadTitle: 'Upload New File',
                UploadSelectLbl: 'Select a file to upload',
                UploadProgressLbl: '(Upload in progress, please wait...)',
                UploadBtn: 'Upload Selected File',
                UploadBtnCancel: 'Cancel',
                UploadNoFileMsg: 'Please select a file from your computer.',
                UploadNoFolder: 'Please select a folder before uploading.',
                UploadNoPerms: 'File upload not allowed.',
                UploadUnknError: 'Error sending the file.',
                UploadExtIncorrect: 'File extension not allowed in this folder.',
                UploadLabel: 'Files to Upload',
                UploadTotalFiles: 'Total Files:',
                UploadTotalSize: 'Total Size:',
                UploadSend: 'Upload',
                UploadAddFiles: 'Add Files',
                UploadClearFiles: 'Clear Files',
                UploadCancel: 'Cancel Upload',
                UploadRemove: 'Remove',
                UploadRemoveTip: 'Remove !f',
                UploadUploaded: 'Uploaded !n%',
                UploadProcessing: 'Processing...',
                SetTitle: 'Settings',
                SetView: 'View:',
                SetViewThumb: 'Thumbnails',
                SetViewList: 'List',
                SetDisplay: 'Display:',
                SetDisplayName: 'File Name',
                SetDisplayDate: 'Date',
                SetDisplaySize: 'File Size',
                SetSort: 'Sorting:',
                SetSortName: 'by File Name',
                SetSortDate: 'by Date',
                SetSortSize: 'by Size',
                SetSortExtension: 'by Extension',
                FilesCountEmpty: '<Empty Folder>',
                FilesCountOne: '1 file',
                FilesCountMany: '%1 files',
                Kb: '%1 KB',
                Mb: '%1 MB',
                Gb: '%1 GB',
                SizePerSecond: '%1/s',
                ErrorUnknown: 'It was not possible to complete the request. (Error %1)',
                Errors: {
                    10: 'Invalid command.',
                    11: 'The resource type was not specified in the request.',
                    12: 'The requested resource type is not valid.',
                    102: 'Invalid file or folder name.',
                    103: 'It was not possible to complete the request due to authorization restrictions.',
                    104: 'It was not possible to complete the request due to file system permission restrictions.',
                    105: 'Invalid file extension.',
                    109: 'Invalid request.',
                    110: 'Unknown error.',
                    111: 'It was not possible to complete the request due to resulting file size.',
                    115: 'A file or folder with the same name already exists.',
                    116: 'Folder not found. Please refresh and try again.',
                    117: 'File not found. Please refresh the files list and try again.',
                    118: 'Source and target paths are equal.',
                    201: 'A file with the same name is already available. The uploaded file was renamed to "%1".',
                    202: 'Invalid file.',
                    203: 'Invalid file. The file size is too big.',
                    204: 'The uploaded file is corrupt.',
                    205: 'No temporary folder is available for upload in the server.',
                    206: 'Upload cancelled due to security reasons. The file contains HTML-like data.',
                    207: 'The uploaded file was renamed to "%1".',
                    300: 'Moving file(s) failed.',
                    301: 'Copying file(s) failed.',
                    500: 'The file browser is disabled for security reasons. Please contact your system administrator and check the CKFinder configuration file.',
                    501: 'The thumbnails support is disabled.'
                },
                ErrorMsg: {
                    FileEmpty: 'The file name cannot be empty.',
                    FileExists: 'File %s already exists.',
                    FolderEmpty: 'The folder name cannot be empty.',
                    FolderExists: 'Folder %s already exists.',
                    FolderNameExists: 'Folder already exists.',
                    FileInvChar: 'The file name cannot contain any of the following characters: \n\\ / : * ? " < > |',
                    FolderInvChar: 'The folder name cannot contain any of the following characters: \n\\ / : * ? " < > |',
                    PopupBlockView: 'It was not possible to open the file in a new window. Please configure your browser and disable all popup blockers for this site.',
                    XmlError: 'It was not possible to properly load the XML response from the web server.',
                    XmlEmpty: 'It was not possible to load the XML response from the web server. The server returned an empty response.',
                    XmlRawResponse: 'Raw response from the server: %s'
                },
                Imageresize: {
                    dialogTitle: 'Resize %s',
                    sizeTooBig: 'Cannot set image height or width to a value bigger than the original size (%size).',
                    resizeSuccess: 'Image resized successfully.',
                    thumbnailNew: 'Create a new thumbnail',
                    thumbnailSmall: 'Small (%s)',
                    thumbnailMedium: 'Medium (%s)',
                    thumbnailLarge: 'Large (%s)',
                    newSize: 'Set a new size',
                    width: 'Width',
                    height: 'Height',
                    invalidHeight: 'Invalid height.',
                    invalidWidth: 'Invalid width.',
                    invalidName: 'Invalid file name.',
                    newImage: 'Create a new image',
                    noExtensionChange: 'File extension cannot be changed.',
                    imageSmall: 'Source image is too small.',
                    contextMenuName: 'Resize',
                    lockRatio: 'Lock ratio',
                    resetSize: 'Reset size'
                },
                Fileeditor: {
                    save: 'Save',
                    fileOpenError: 'Unable to open file.',
                    fileSaveSuccess: 'File saved successfully.',
                    contextMenuName: 'Edit',
                    loadingFile: 'Loading file, please wait...'
                },
                Maximize: {
                    maximize: 'Maximize',
                    minimize: 'Minimize'
                },
                Gallery: {
                    current: 'Image {current} of {total}'
                },
                Zip: {
                    extractHereLabel: 'Extract here',
                    extractToLabel: 'Extract to...',
                    downloadZipLabel: 'Download as zip',
                    compressZipLabel: 'Compress to zip',
                    removeAndExtract: 'Remove existing and extract',
                    extractAndOverwrite: 'Extract overwriting existing files',
                    extractSuccess: 'File extracted successfully.'
                },
                Search: {
                    searchPlaceholder: 'Search'
                }
            };
            (function() {
                var r = 1,
                        s = 2,
                        t = 4,
                        u = 8,
                        v = 16,
                        w = 32,
                        x = 64,
                        y = 128;
                a.aL.Acl = function(z) {
                    var A = this;
                    if (!z)
                        z = 0;
                    A.folderView = (z & r) == r;
                    A.folderCreate = (z & s) == s;
                    A.folderRename = (z & t) == t;
                    A.folderDelete = (z & u) == u;
                    A.fileView = (z & v) == v;
                    A.fileUpload = (z & w) == w;
                    A.fileRename = (z & x) == x;
                    A.fileDelete = (z & y) == y;
                };
                o.add('acl');
            })();
            (function() {
                o.add('connector', {
                    bM: [],
                    bz: function(s) {
                        s.on('appReady', function() {
                            s.connector = new a.aL.Connector(s);
                            var t = s.config.resourceType,
                                    u = t ? {
                                        type: t
                                    } : null;
                            s.connector.sendCommand('Init', u, function(v) {
                                var w;
                                if (v.checkError())
                                    return;
                                var x = "\103o\156nec\164or\057\103on\156\145\143t\157rIn\146\157\057";
                                a.ed = v.selectSingleNode(x + "\100\163").value;
                                a.bF = v.selectSingleNode(x + "\100c").value + '----';
                                s.config.thumbsEnabled = v.selectSingleNode(x + "@th\165\155\142\163E\156\141ble\144").value == 'true';
                                s.config.thumbsDirectAccess = false;
                                if (s.config.thumbsEnabled) {
                                    w = v.selectSingleNode(x + "@thum\142\163\125rl");
                                    if (w)
                                        s.config.thumbsUrl = w.value;
                                    w = v.selectSingleNode(x + "@th\165mbs\104\151r\145\143tAc\143ess");
                                    if (w)
                                        s.config.thumbsDirectAccess = w.value == 'true';
                                    w = v.selectSingleNode(x + "@thu\155bsWi\144t\150");
                                    s.config.thumbsWidth = (w ? parseInt(w.value, 10) : 100) || 100;
                                    w = v.selectSingleNode(x + "@thumbs\110\145ig\150t");
                                    s.config.thumbsHeight = (w ? parseInt(w.value, 10) : 100) || 100;
                                }
                                s.config.imagesMaxWidth = parseInt(v.selectSingleNode(x + "@\151\155g\127i\144\164h").value, 10);
                                s.config.imagesMaxHeight = parseInt(v.selectSingleNode(x + "@im\147\110ei\147h\164").value, 10);
                                w = v.selectSingleNode(x + "\100\165\160l\157a\144Ma\170S\151\172\145");
                                s.config.uploadMaxSize = w ? parseInt(w.value, 10) : 0;
                                w = v.selectSingleNode(x + "@\165\160\154o\141\144\103heckI\155age\163");
                                s.config.uploadCheckImages = w ? w.value == 'true' : false;
                                var y = v.selectSingleNode(x + "@plug\151ns"),
                                        z = y && y.value;
                                if (z && z.length)
                                    o.load(z.split(','), function(A) {
                                        var B = [],
                                                C = [],
                                                D = [];
                                        for (var E in A) {
                                            var F = A[E],
                                                    G = F.lang,
                                                    H = o.getPath(E),
                                                    I = null;
                                            if (!s.plugins[E])
                                                s.plugins[E] = A[E];
                                            else
                                                continue;
                                            A[E].name = E;
                                            F.pathName = H;
                                            if (G) {
                                                I = k.indexOf(G, s.langCode) >= 0 ? s.langCode : G[0];
                                                if (!F.lang[I])
                                                    D.push(a.getUrl(H + 'lang/' + I + '.js'));
                                                else {
                                                    k.extend(s.lang, F.lang[I]);
                                                    I = null;
                                                }
                                            }
                                            C.push(I);
                                            B.push(F);
                                        }
                                        a.scriptLoader.load(D, function() {
                                            var J = ['eK', 'bz', 'gr'];
                                            for (var K = 0; K < J.length; K++)
                                                for (var L = 0; L < B.length; L++) {
                                                    var M = B[L];
                                                    if (K === 0 && C[L] && M.lang)
                                                        k.extend(s.lang, M.lang[C[L]]);
                                                    if (M[J[K]]) {
                                                        a.log('[PLUGIN] ' + M.name + '.' + J[K]);
                                                        M[J[K]](s);
                                                    }
                                                }
                                            s.cr('uiReady');
                                            s.cr('appReady');
                                            s.oW('pluginsLoaded', {
                                                step: 2,
                                                jN: s.connector
                                            });
                                            s.cr('connectorInitialized', {
                                                xml: v
                                            });
                                        });
                                    });
                                else {
                                    s.oW('pluginsLoaded', {
                                        step: 2,
                                        jN: s.connector
                                    });
                                    s.cr('connectorInitialized', {
                                        xml: v
                                    });
                                }
                            });
                        });
                    }
                });
                a.aL.Connector = function(s) {
                    this.app = s;
                    var t = s.config.connectorLanguage || 'php';
                    if (s.config.connectorPath)
                        this.oN = s.config.connectorPath;
                    else
                        this.oN = a.basePath + 'core/connector/' + t + '/connector.' + t;
                };
                a.aL.Connector.prototype = {
                    ERROR_NONE: 0,
                    ERROR_CUSTOMERROR: 1,
                    ERROR_INVALIDCOMMAND: 10,
                    ERROR_TYPENOTSPECIFIED: 11,
                    ERROR_INVALIDTYPE: 12,
                    ERROR_INVALIDNAME: 102,
                    ERROR_UNAUTHORIZED: 103,
                    ERROR_ACCESSDENIED: 104,
                    ERROR_INVALIDEXTENSION: 105,
                    ERROR_INVALIDREQUEST: 109,
                    ERROR_UNKNOWN: 110,
                    ERROR_ALREADYEXIST: 115,
                    ERROR_FOLDERNOTFOUND: 116,
                    ERROR_FILENOTFOUND: 117,
                    ERROR_SOURCE_AND_TARGET_PATH_EQUAL: 118,
                    ERROR_UPLOADEDFILERENAMED: 201,
                    ERROR_UPLOADEDINVALID: 202,
                    ERROR_UPLOADEDTOOBIG: 203,
                    ERROR_UPLOADEDCORRUPT: 204,
                    ERROR_UPLOADEDNOTMPDIR: 205,
                    ERROR_UPLOADEDWRONGHTMLFILE: 206,
                    ERROR_UPLOADEDINVALIDNAMERENAMED: 207,
                    ERROR_MOVE_FAILED: 300,
                    ERROR_COPY_FAILED: 301,
                    ERROR_CONNECTORDISABLED: 500,
                    ERROR_THUMBNAILSDISABLED: 501,
                    currentFolderUrl: function() {
                        if (this.app.aV)
                            return this.app.aV.getUrl();
                    },
                    currentType: function() {
                        if (this.app.aV)
                            return this.app.aV.type;
                    },
                    currentTypeHash: function() {
                        if (this.app.aV)
                            return a.getResourceType(this.app.aV.type).hash;
                    },
                    currentResourceType: function() {
                        return a.getResourceType(this.currentType());
                    },
                    sendCommand: function(s, t, u, v, w) {
                        var x = this.composeUrl(s, t, v, w),
                                y = this;
                        if (u)
                            return a.ajax.loadXml(x, function(z) {
                                z.hy = y.app;
                                y.app.oW('connectorResponse', {
                                    xml: z
                                });
                                u(k.extend(z, r));
                            });
                        else
                            return a.ajax.loadXml(x, function(z) {
                                y.app.oW('connectorResponse', {
                                    xml: z
                                });
                            });
                    },
                    sendCommandPost: function(s, t, u, v, w, x) {
                        var y = this.composeUrl(s, t, w, x),
                                z = this;
                        if (!u)
                            u = {};
                        u.CKFinderCommand = true;
                        if (v)
                            return a.ajax.loadXml(y, function(A) {
                                A.hy = z.app;
                                z.app.oW('connectorResponse', {
                                    xml: A
                                });
                                v(k.extend(A, r));
                            }, this.composeUrlParams(u));
                        else
                            return a.ajax.loadXml(y, function(A) {
                                z.app.oW('connectorResponse', {
                                    xml: A
                                });
                            }, this.composeUrlParams(u));
                    },
                    composeUrl: function(s, t, u, v) {
                        var z = this;
                        var w = z.oN + '?command=' + encodeURIComponent(s);
                        if (s != 'Init') {
                            var x = '';
                            if (!v)
                                v = z.app.aV;
                            if (u)
                                x = z.app.getResourceType(u).hash;
                            else
                                x = z.app.getResourceType(v.type).hash;
                            w += '&type=' + encodeURIComponent(u || z.app.aV.type) + '&currentFolder=' + encodeURIComponent(v.getPath() || '') + '&langCode=' + z.app.langCode + '&hash=' + x;
                        }
                        if (t) {
                            var y = z.composeUrlParams(t);
                            if (y)
                                w += '&' + y;
                        }
                        if (z.app.id)
                            w += '&id=' + encodeURIComponent(z.app.id);
                        if (z.app.config.connectorInfo)
                            w += (z.app.config.connectorInfo.charAt(0) != '&' ? '&' : '') + z.app.config.connectorInfo;
                        return w;
                    },
                    composeUrlParams: function(s) {
                        if (!s)
                            return '';
                        var t = '';
                        for (var u in s) {
                            if (t.length)
                                t += '&';
                            t += encodeURIComponent(u) + '=' + encodeURIComponent(s[u]);
                        }
                        return t;
                    }
                };
                var r = {
                    checkError: function() {
                        var y = this;
                        var s = y.getErrorNumber(),
                                t = y.hy.connector;
                        if (s == t.ERROR_NONE)
                            return false;
                        if (s === -1)
                            return true;
                        var u = y.getErrorMessage();
                        a.log('[ERROR] ' + s);
                        var v;
                        if (s == t.ERROR_CUSTOMERROR)
                            v = u;
                        else {
                            v = y.hy.lang.Errors[s];
                            if (v)
                                for (var w = 0; w <= arguments.length; w++) {
                                    var x = w === 0 ? u : arguments[w - 1];
                                    v = v.replace(/%(\d+)/, x);
                                }
                            else
                                v = y.hy.lang.ErrorUnknown.replace(/%1/, s);
                        }
                        y.hy.msgDialog('', v);
                        return s != t.ERROR_UPLOADEDFILERENAMED;
                    },
                    getErrorNumber: function() {
                        var s = this.selectSingleNode && this.selectSingleNode('Connector/Error/@number');
                        if (!s)
                            return -1;
                        return parseInt(s.value, 10);
                    },
                    getErrorMessage: function() {
                        var s = this.selectSingleNode && this.selectSingleNode('Connector/Error/@text');
                        if (!s)
                            return '';
                        return s.value;
                    }
                };
            })();
            o.add('resource', {
                bM: ['connector'],
                bz: function(r) {
                    r.resourceTypes = [];
                    r.on('connectorInitialized', function(s) {
                        var t = s.data.xml.selectNodes('Connector/ResourceTypes/ResourceType');
                        for (var u = 0; u < t.length; u++) {
                            var v = t[u].attributes;
                            r.resourceTypes.push(new a.aL.ResourceType(r, {
                                name: v.getNamedItem('name').value,
                                url: v.getNamedItem('url').value,
                                hasChildren: v.getNamedItem('hasChildren').value,
                                allowedExtensions: v.getNamedItem('allowedExtensions').value,
                                deniedExtensions: v.getNamedItem('deniedExtensions').value,
                                acl: v.getNamedItem('acl').value,
                                hash: v.getNamedItem('hash').value,
                                maxSize: v.getNamedItem('maxSize').value
                            }));
                        }
                        r.cr('resourcesReceived', {
                            hK: r.resourceTypes
                        });
                    });
                    r.getResourceType = function(s) {
                        for (var t = 0; t < this.resourceTypes.length; t++) {
                            var u = this.resourceTypes[t];
                            if (u.name == s)
                                return u;
                        }
                        return null;
                    };
                }
            });
            (function() {
                a.aL.ResourceType = function(s, t) {
                    var u = this;
                    u.app = s;
                    u.name = t.name;
                    u.url = t.url;
                    u.hasChildren = t.hasChildren === 'true';
                    u.defaultView = 'Thumbnails';
                    u.allowedExtensions = t.allowedExtensions;
                    u.deniedExtensions = t.deniedExtensions;
                    u.oT = r(t.allowedExtensions);
                    u.ms = r(t.deniedExtensions);
                    u.nS = t.acl;
                    u.hash = t.hash;
                    u.maxSize = t.maxSize;
                };
                a.aL.ResourceType.prototype = {
                    isExtensionAllowed: function(s) {
                        var t = this;
                        s = s.toLowerCase();
                        return (t.deniedExtensions.length === 0 || !t.ms[s]) && (t.allowedExtensions.length === 0 || !!t.oT[s]);
                    },
                    allowedExtensions: function() {
                        return this.allowedExtensions;
                    },
                    getRootFolder: function() {
                        for (var s = 0; s < this.app.folders.length; s++) {
                            var t = this.app.folders[s];
                            if (t.isRoot && t.type == this.name)
                                return t;
                        }
                        return undefined;
                    }
                };

                function r(s) {
                    var t = {};
                    if (s.length > 0) {
                        var u = s.toLowerCase().split(',');
                        for (var v = 0; v < u.length; v++)
                            t[u[v]] = true;
                    }
                    return t;
                }
                ;
            })();
            (function() {
                var r = function(s) {
                    this.app = s;
                };
                r.prototype.er = function(s, t) {
                    var x = this;
                    if (x.id)
                        return;
                    x.toolbarId = 'cke_' + k.getNextNumber();
                    x.id = 'cke_' + k.getNextNumber();
                    x.placeholderId = 'cke_' + k.getNextNumber();
                    var u = {
                        id: x.id,
                        placeholderId: x.placeholderId,
                        lastTimeout: -1,
                        app: s
                    }, v = k.addFunction(s.search.doSearch, u),
                            w = k.addFunction(s.search.onFocus, u);
                    t.push('<span class="cke_search_box" id="', x.toolbarId, '" class="cke_toolbar" role="presentation"><span class="cke_toolbar_start"></span>');
                    t.push('<input id="' + x.id + '" ');
                    t.push(' onkeyup="window.parent.CKFinder._.callFunction(', v, ', this);"');
                    t.push(' oninput="window.parent.CKFinder._.callFunction(', v, ', this);"');
                    t.push(' onfocus="window.parent.CKFinder._.callFunction(', w, ', this);"');
                    t.push('>');
                    t.push('<span id="' + x.placeholderId + '" class="cke_search_placeholder" onclick="window.parent.CKFinder._.callFunction(', w, ', this);">' + s.lang.Search.searchPlaceholder + '</span>');
                    t.push('<span class="cke_toolbar_end"></span></span>');
                };
                r.prototype.doSearch = function() {
                    var s = this.app.ld['filesview.filesview'].oE().shownFiles.length,
                            t = this.app.document.getById(this.id).getValue(),
                            u = this.app;
                    if (this.lastTimeout) {
                        clearTimeout(this.lastTimeout);
                        this.lastTimeout = null;
                    }
                    if (s < 200)
                        u.ld['filesview.filesview'].oW('requestRenderFiles', {
                            lookup: t
                        });
                    else
                        this.lastTimeout = setTimeout(function() {
                            u.ld['filesview.filesview'].oW('requestRenderFiles', {
                                lookup: t
                            });
                        }, 1000);
                };
                r.prototype.onFocus = function() {
                    var s = this;
                    s.app.document.getById(s.placeholderId).setStyle('display', 'none');
                    s.app.document.getById(s.id).$.focus();
                };
                r.prototype.reset = function() {
                    var s = this;
                    s.app.document.getById(s.id).setValue('');
                    s.app.document.getById(s.placeholderId).setStyle('display', 'inline');
                };
                o.add('search', {
                    bM: ['foldertree'],
                    eK: function(s) {
                        s.search = new r(s);
                    },
                    bz: function(s) {
                        s.on('appReady', function() {
                            s.ld['foldertree.foldertree'].on('beforeSelectFolder', function() {
                                s.search.reset();
                            });
                            s.ld['formpanel.formpanel'].on('afterUploadFile', function() {
                                s.search.reset();
                            });
                        });
                    }
                });
            })();
            (function() {
                var r = {
                    iz: /[\\\/:\*\?"<>\|]/
                };
                o.add('folder', {
                    bM: ['resource', 'connector', 'acl'],
                    bz: function(v) {
                        v.folders = t(v);
                        v.aV = null;
                        v.on('resourcesReceived', function B(w) {
                            var x = [],
                                    y = w.data.hK;
                            for (var z = 0; z < y.length; z++) {
                                var A = y[z];
                                x.push(new a.aL.Folder(v, A.name, A.name, A.hasChildren, A.nS));
                                x[x.length - 1].isRoot = true;
                            }
                            v.oW('requestAddFolder', {
                                folders: x
                            }, function K() {
                                var C = v.config.startupPath || '',
                                        D = 0,
                                        E = '',
                                        F = '';
                                if (v.config.rememberLastFolder) {
                                    var G = v.id ? 'CKFinder_Path_' + v.id : 'CKFinder_Path';
                                    E = decodeURIComponent(k.getCookie(G)) || '';
                                }
                                if (C && !v.qn) {
                                    F = C;
                                    D = 1;
                                } else if (E)
                                    F = E;
                                else if (C)
                                    F = C;
                                else if (v.resourceTypes.length)
                                    F = v.resourceTypes[0].name + '/';
                                if (F) {
                                    a.log('[FOLDER] Opening startup path: ' + F);
                                    var H = F.split(':');
                                    if (!v.getResourceType(H[0]) || H.length < 2)
                                        H = [v.resourceTypes[0].name, '/'];
                                    var I = v.ld['foldertree.foldertree'],
                                            J = /(.*\/)(.*)$/.exec(H[1]);
                                    I.tools.jL(H[0], J[1], function N(L) {
                                        if (!L)
                                            return;
                                        a.log('[FOLDER] Opening startup folder: ', L);
                                        var M = !D && (H[2] == '1' || H[2] === undefined);
                                        if (M && v.config.startupFolderExpanded === false)
                                            M = 0;
                                        I.oW('requestSelectFolder', {
                                            folder: L,
                                            expand: M,
                                            file: J[2] && L.type == H[0] && L.getPath() == J[1] ? J[2] : ''
                                        });
                                    });
                                }
                            });
                        });
                        v.bD('RemoveFolder', {
                            readOnly: false,
                            exec: function(w) {
                                var x = w.aV;
                                if (x) {
                                    if (x.isRoot || !x.acl.folderDelete)
                                        return;
                                    w.fe('', w.lang.FolderDelete.replace('%1', x.name), function() {
                                        w.oW('requestProcessingFolder', {
                                            folder: x
                                        });
                                        x.remove();
                                    });
                                }
                            }
                        });
                        v.bD('CreateSubFolder', {
                            readOnly: false,
                            exec: function(w) {
                                var x = w.aV;
                                if (x)
                                    w.hs(w.lang.NewNameDlgTitle, w.lang.FolderRename, '', function(y) {
                                        y = k.trim(y);
                                        if (y)
                                            try {
                                                w.oW('requestProcessingFolder', {
                                                    folder: x
                                                });
                                                x.createNewFolder(y);
                                            } catch (z) {
                                                if (z instanceof a.dU) {
                                                    w.oW('requestRepaintFolder', {
                                                        folder: x
                                                    });
                                                    w.msgDialog('', z.message);
                                                } else
                                                    throw z;
                                            }
                                    });
                            }
                        });
                        v.bD('RenameFolder', {
                            readOnly: false,
                            exec: function(w) {
                                var x = w.aV;
                                if (x) {
                                    if (x.isRoot || !x.acl.folderRename)
                                        return;
                                    w.hs(w.lang.RenameDlgTitle, w.lang.FolderRename, w.aV.name, function(y) {
                                        y = k.trim(y);
                                        if (y)
                                            try {
                                                x.rename(y);
                                            } catch (z) {
                                                if (z instanceof a.dU) {
                                                    w.oW('requestRepaintFolder', {
                                                        folder: x
                                                    });
                                                    w.msgDialog('', z.message);
                                                } else
                                                    throw z;
                                            }
                                    });
                                }
                            }
                        });
                        if (v.eU) {
                            v.dZ('folder0', 99);
                            v.dZ('folder1', 100);
                            v.dZ('folder2', 101);
                            v.dZ('folder3', 102);
                            v.eU({
                                createSubFolder: {
                                    label: v.lang.NewSubFolder,
                                    command: 'CreateSubFolder',
                                    group: 'folder1'
                                },
                                renameFolder: {
                                    label: v.lang.Rename,
                                    command: 'RenameFolder',
                                    group: 'folder1'
                                },
                                removeFolder: {
                                    label: v.lang.Delete,
                                    command: 'RemoveFolder',
                                    group: 'folder2'
                                }
                            });
                        }
                    }
                });
                a.aL.Folder = function(v, w, x, y, z) {
                    var A = this;
                    A.app = v;
                    A.type = w || '';
                    A.name = x || '';
                    A.hasChildren = y == undefined || y === null ? true : !!y;
                    A.isRoot = false;
                    A.isOpened = false;
                    A.parent = null;
                    A.isDirty = false;
                    A.acl = new a.aL.Acl(z);
                    A.index = t(v).push(A) - 1;
                    A.childFolders = null;
                };

                function s(v, w, x, y, z) {
                    if (v.childFolders === null)
                        v.childFolders = [];
                    var A = new a.aL.Folder(v.app, w, x, y, z);
                    A.parent = v;
                    A.nh = v.isRoot ? 0 : v.nh + 1;
                    v.childFolders.push(A);
                    return A;
                }
                ;

                function t(v) {
                    v.folders || (v.folders = []);
                    return v.folders;
                }
                ;
                a.aL.Folder.prototype = {
                    getPath: function() {
                        var v = this,
                                w = v.isRoot ? '/' : v.name;
                        while (v.parent) {
                            v = v.parent;
                            w = v.isRoot ? '/' + w : v.name + '/' + w;
                        }
                        return v != this ? w + '/' : w;
                    },
                    getUrl: function() {
                        var v = this,
                                w = '';
                        while (v) {
                            w = v.isRoot ? this.app.getResourceType(v.type).url + w : encodeURIComponent(v.name) + '/' + w;
                            v = v.parent;
                        }
                        return w;
                    },
                    getUploadUrl: function() {
                        return this.app.connector.composeUrl('FileUpload', {}, this.type, this);
                    },
                    getResourceType: function() {
                        return this.app.getResourceType(this.type);
                    },
                    updateReference: function() {
                        var w = this;
                        if (w.app.folders[w.index] == w)
                            return w;
                        for (var v = 0; v < w.parent.childFolders.length; v++) {
                            if (w.parent.childFolders[v].name == w.name)
                                return w.parent.childFolders[v];
                        }
                        return undefined;
                    },
                    getChildren: function(v, w) {
                        var x = this,
                                y = x.childFolders;
                        if (x.hl && !w) {
                            a.log('[FOLDER] getChildrenLock active, defering callback...');
                            x.app.oW('requestLoadingFolder', {
                                folder: x
                            });
                            var z = 100;
                            setTimeout(function() {
                                if (!x.hl)
                                    v(y);
                                else if (z <= 3000)
                                    setTimeout(arguments.callee, z *= 2);
                                else {
                                    a.log('[FOLDER] TIMEOUT for getChildrenLock defered callback!');
                                    x.hl = false;
                                    x.getChildren(v);
                                }
                            });
                            return undefined;
                        }
                        if (y && !x.isDirty && !w) {
                            v(y);
                            return y;
                        }
                        x.hl = true;
                        if (x.isDirty && y) {
                            a.log('[FOLDER] Clearing folder children cache.');
                            for (var A = 0; A < y.length; A++)
                                delete x.app.folders[y[A].index];
                        }
                        x.app.oW('requestLoadingFolder', {
                            folder: x
                        });
                        this.app.connector.sendCommand('GetFolders', null, function(B) {
                            if (B.checkError()) {
                                x.app.oW('requestRepaintFolder', {
                                    folder: x
                                });
                                return;
                            }
                            var C = B.selectSingleNode('Connector/@resourceType').value;
                            x.hm = true;
                            var D = B.selectNodes('Connector/Folders/Folder'),
                                    E = [];
                            x.childFolders = null;
                            for (var F = 0; F < D.length; F++) {
                                var G = D[F].attributes.getNamedItem('name').value,
                                        H = D[F].attributes.getNamedItem('hasChildren').value == 'true',
                                        I = parseInt(D[F].attributes.getNamedItem('acl').value, 10);
                                E.push(s(x, C, G, H, I));
                            }
                            x.hasChildren = !!D.length;
                            x.isDirty = false;
                            x.hl = null;
                            x.app.oW('requestRepaintFolder', {
                                folder: x
                            });
                            v(E);
                        }, x.type, x);
                        return null;
                    },
                    mapLoadedDescendants: function(v) {
                        if (!this.childFolders)
                            return;
                        for (var w = 0; w < this.childFolders.length; w++) {
                            var x = this.childFolders[w];
                            x.mapLoadedDescendants(v);
                            v(x);
                        }
                    },
                    select: function() {
                        this.app.oW('requestSelectFolder', {
                            folder: this
                        });
                    },
                    isSelected: function() {
                        return this.app.aV && this == this.app.aV;
                    },
                    deselect: function() {
                        this.app.oW('requestSelectFolder');
                    },
                    open: function(v) {
                        if (v && !this.hm)
                            return;
                        this.app.oW('requestExpandFolder', {
                            folder: this
                        });
                    },
                    close: function() {
                        this.app.oW('requestExpandFolder', {
                            folder: this,
                            collapse: 1
                        });
                    },
                    hU: function() {
                        var v = 1,
                                w = this;
                        while (w) {
                            v++;
                            w = w.parent;
                        }
                        return v;
                    },
                    toggle: function() {
                        var v = this;
                        if (!v.hasChildren)
                            return;
                        if (v.isOpened)
                            v.close();
                        else
                            v.open();
                    },
                    createNewFolder: function(v) {
                        u(v, this.app);
                        var w = this;
                        w.isDirty = true;
                        w.app.connector.sendCommandPost('CreateFolder', {
                            NewFolderName: v
                        }, null, function(x) {
                            if (x.checkError()) {
                                w.app.oW('requestRepaintFolder', {
                                    folder: w
                                });
                                return;
                            }
                            w.hasChildren = true;
                            w.app.oW('afterCommandExecDefered', {
                                name: 'CreateFolder',
                                ip: w,
                                uv: v
                            });
                        }, this.type, this);
                    },
                    rename: function(v) {
                        u(v, this.app);
                        var w = this;
                        this.app.oW('requestProcessingFolder', {
                            folder: w
                        });
                        w.parent.isDirty = true;
                        if (w.name == v) {
                            w.app.oW('requestRepaintFolder', {
                                folder: w
                            });
                            return;
                        }
                        w.app.connector.sendCommandPost('RenameFolder', {
                            NewFolderName: v
                        }, null, function(x) {
                            if (x.checkError()) {
                                w.app.oW('requestRepaintFolder', {
                                    folder: w
                                });
                                return;
                            }
                            w.parent.isDirty = false;
                            w.name = x.selectSingleNode('Connector/RenamedFolder/@newName').value;
                            w.app.oW('requestRepaintFolder', {
                                folder: w
                            });
                        }, this.type, this);
                    },
                    remove: function() {
                        var v = this;
                        v.deselect();
                        v.parent.isDirty = true;
                        this.app.oW('requestProcessingFolder', {
                            folder: v
                        });
                        v.app.connector.sendCommandPost('DeleteFolder', null, null, function(w) {
                            if (w.checkError()) {
                                v.app.oW('requestRepaintFolder', {
                                    folder: v
                                });
                                return;
                            }
                            v.app.oW('requestRemoveFolder', {
                                folder: v
                            }, function() {
                                var x = k.indexOf(v.parent.childFolders, v),
                                        y = v.index,
                                        z = v.parent,
                                        A = v.app;
                                z.childFolders[x].mapLoadedDescendants(function(B) {
                                    A.folders[B.index].isDeleted = true;
                                    delete A.folders[B.index];
                                });
                                z.childFolders.splice(x, 1);
                                A.folders[y].isDeleted = true;
                                delete A.folders[y];
                                if (z.childFolders.length === 0) {
                                    z.childFolders = null;
                                    z.hasChildren = false;
                                }
                                if (v.releaseDomNodes)
                                    v.releaseDomNodes();
                                A.oW('afterCommandExecDefered', {
                                    name: 'RemoveFolder',
                                    ip: z,
                                    uN: y,
                                    folder: v
                                });
                            });
                        }, this.type, this);
                    },
                    'toString': function() {
                        return this.getPath();
                    }
                };

                function u(v, w) {
                    if (!v || v.length === 0)
                        throw new a.dU('name_empty', w.lang.ErrorMsg.FolderEmpty);
                    if (r.iz.test(v))
                        throw new a.dU('name_invalid_chars', w.lang.ErrorMsg.FolderInvChar);
                    return true;
                }
                ;
            })();
            (function() {
                var r = '<a href="javascript:void(0)" class="dropdown">▼</a>';
                o.add('foldertree', {
                    bM: ['folder'],
                    onLoad: function z() {
                        s();
                        t();
                    },
                    bz: function B(z) {
                        var A = this;
                        z.on('themeSpace', function D(C) {
                            if (C.data.space == 'sidebar')
                                C.data.html += "<div id='folders_view' class='view widget' tabindex='0'><h2 id='folders_view_label'>" + z.lang.FoldersTitle + '</h2>' + "<div class='folder_tree_wrapper wrapper'>" + "<div class='selection'></div>" + "<ul class='folder_tree no_list' role='tree navigation' aria-labelledby='folders_view_label'>" + '</ul>' + '</div>' + '</div>';
                        });
                        z.on('uiReady', function F(C) {
                            if (!z.config.showContextMenuArrow)
                                r = '';
                            var D = z.document.getById('folders_view');
                            D.hX();
                            h.opera && D.on('dblclick', function(G) {
                                G.data.preventDefault();
                            });
                            var E = a.ld.bz(z, 'foldertree', A, D);
                            if (z.bj) {
                                z.bj.lX(D);
                                z.bj.kh(function O(G, H) {
                                    if (G.dS() == 'folders_view')
                                        return undefined;
                                    var I = true;
                                    if (z.aV) {
                                        var J = z.aV.liNode().dS();
                                        if (G.dS() === J || G.getParent().dS() === J)
                                            I = false;
                                    }
                                    if (I) {
                                        z.oW('requestSelectFolder', {
                                            folder: null
                                        });
                                        z.oW('requestSelectFolder', {
                                            folder: G
                                        });
                                    }
                                    var K = z.aV;
                                    if (K && !z.config.readOnly) {
                                        var L = K.acl,
                                                M = K.isRoot,
                                                N = {
                                                    createSubFolder: L.folderCreate ? a.aS : a.aY,
                                                    renameFolder: !M && L.folderRename ? a.aS : a.aY,
                                                    removeFolder: !M && L.folderDelete ? a.aS : a.aY
                                                };
                                        E.oW('beforeContextMenu', {
                                            bj: N,
                                            folder: K
                                        });
                                        return N;
                                    }
                                }, D);
                            }
                        });
                        z.bD('foldertreeFocus', {
                            exec: function(C) {
                                var D = C.layout.pS(),
                                        E = C.ld['foldertree.foldertree'],
                                        F = E.tools.ew;
                                D.focus();
                                F && F.focus();
                            }
                        });
                    }
                });

                function s() {
                    var z = a.ld.hS('foldertree', 'foldertree');
                    z.dT.push(function() {
                        var B = this.bn();
                        if (!B.hasClass('view'))
                            B = B.getParent();
                        k.mH(B);
                    });
                    z.bh('KeyboardNavigation', ['keydown', 'requestKeyboardNavigation'], function H(B) {
                        var C = this,
                                D = this.tools.cq(B),
                                E = 0;
                        if (B.data && B.data.bK) {
                            var F = B.data.bK();
                            E = F.$ == C.bn().$;
                        }
                        if (!D && !E)
                            return;
                        var G = k.extend({}, B.data, {
                            folder: D
                        }, true);
                        this.oW('beforeKeyboardNavigation', G, function O(I, J) {
                            if (I)
                                return;
                            try {
                                var K = B.data.db();
                                if (E && K >= 37 && K <= 40) {
                                    var L = C.app.folders[0];
                                    if (L)
                                        this.tools.cT(L);
                                } else {
                                    var M;
                                    if (K == 38) {
                                        B.data.preventDefault();
                                        M = D.liNode();
                                        if (M.gE()) {
                                            var N = this.tools.cq(M.cf());
                                            while (N.isOpened && N.hasChildren) {
                                                if (N.childFolders.length)
                                                    N = N.childFolders[N.childFolders.length - 1];
                                                else
                                                    break;
                                            }
                                            this.tools.cT(N);
                                        } else if (!D.isRoot)
                                            this.tools.cT(D.parent);
                                    } else if (K == 39 && D.hasChildren) {
                                        if (D.isOpened)
                                            D.getChildren(function(P) {
                                                C.tools.cT(P[0]);
                                            });
                                        else
                                            this.oW('requestExpandFolder', {
                                                folder: D
                                            });
                                    } else if (K == 40) {
                                        B.data.preventDefault();
                                        M = D.liNode();
                                        if (D.isOpened && D.hasChildren)
                                            D.getChildren(function(P) {
                                                C.tools.cT(P[0]);
                                            });
                                        else if (M.ge())
                                            this.tools.cT(this.tools.cq(M.dG()));
                                        else if (!D.isRoot && D.parent)
                                            (function(P) {
                                                var Q = P.liNode();
                                                if (Q.ge())
                                                    C.tools.cT(C.tools.cq(Q.dG()));
                                                else if (P.parent)
                                                    arguments.callee(P.parent);
                                            })(D.parent);
                                    } else if (K == 37) {
                                        if (D.isOpened)
                                            this.oW('requestExpandFolder', {
                                                folder: D,
                                                collapse: 1
                                            });
                                        else if (!D.isRoot && D.parent)
                                            this.tools.cT(D.parent);
                                    } else if (K == 46) {
                                        C.app.oW('requestSelectFolder', {
                                            folder: D
                                        });
                                        C.app.execCommand('RemoveFolder');
                                    } else if (K == 113) {
                                        C.app.oW('requestSelectFolder', {
                                            folder: D
                                        });
                                        C.app.execCommand('RenameFolder');
                                    }
                                }
                                this.oW('successKeyboardNavigation', J);
                                this.oW('afterKeyboardNavigation', J);
                            } catch (P) {
                                P = a.ba(P);
                                this.oW('failedKeyboardNavigation', J);
                                this.oW('afterKeyboardNavigation', J);
                                throw P;
                            }
                        });
                    });
                    z.dT.push(function(B, C) {
                        B.on('afterCommandExecDefered', function(D) {
                            if (!D.data)
                                return;
                            var E = D.data.folder;
                            if (D.data.name == 'RemoveFolder') {
                                if (E == C.tools.ew) {
                                    C.tools.cT();
                                    C.bn().focus();
                                }
                                var F = B.ld['filesview.filesview'].tools.folder,
                                        G = E == F;
                                E.mapLoadedDescendants(function(H) {
                                    if (F == E)
                                        G = true;
                                });
                                C.oW('requestSelectFolder', {
                                    folder: E.parent,
                                    expand: G
                                });
                            } else if (D.data.name == 'RenameFolder')
                                if (E == C.tools.ew)
                                    E.focus();
                        });
                    });
                    z.bh('RemoveFolder', 'requestRemoveFolder', function F(B) {
                        var C = this,
                                D = this.tools.cq(B),
                                E = k.extend({}, B.data, {
                                    folder: D
                                }, true);
                        this.oW('beforeRemoveFolder', E, function I(G, H) {
                            var J = this;
                            if (G)
                                return;
                            try {
                                D.liNode().remove();
                                J.oW('successRemoveFolder', H);
                                J.oW('afterRemoveFolder', H);
                            } catch (K) {
                                J.oW('failedRemoveFolder', H);
                                J.oW('afterRemoveFolder', H);
                                throw a.ba(K);
                            }
                        });
                    }, false);
                    z.bh('LoadingFolder', 'requestLoadingFolder', function F(B) {
                        var C = this,
                                D = this.tools.cq(B);
                        if (!D)
                            return undefined;
                        var E = k.extend({}, B.data, {
                            folder: D
                        }, true);
                        this.oW('beforeLoadingFolder', E, function J(G, H) {
                            if (G)
                                return;
                            var I = H.folder;
                            try {
                                this.on('afterExpandFolder', function(K) {
                                    if (K.data && K.data.folder == I) {
                                        K.removeListener();
                                        var L = I.childrenRootNode().getChild(0);
                                        if (L && L.hasClass('loading')) {
                                            L.remove();
                                            this.oW('requestRepaintFolder', {
                                                folder: I
                                            });
                                            H.step = 2;
                                            C.oW('successLoadingFolder', H);
                                            C.oW('afterLoadingFolder', H);
                                        }
                                    }
                                }, null, null, 1);
                                if (I.childrenRootNode())
                                    I.childrenRootNode().setHtml('<li class="loading">' + C.app.lang.FolderLoading + '</li>');
                                this.oW('requestProcessingFolder', {
                                    folder: I
                                });
                                H.step = 1;
                                this.oW('successLoadingFolder', H);
                            } catch (K) {
                                this.oW('failedLoadingFolder', H);
                                this.oW('afterLoadingFolder', H);
                                throw a.ba(K);
                            }
                        });
                        return undefined;
                    });
                    z.bh('ProcessingFolder', ['requestProcessingFolder'], function C(B) {
                        B.result = this.oW('beforeProcessingFolder', B.data, function H(D, E) {
                            var I = this;
                            if (D)
                                return;
                            try {
                                var F = I.tools.cq(E.folder),
                                        G = F.aNode();
                                G.addClass('processing');
                                I.oW('successProcessingFolder', E);
                                I.oW('afterProcessingFolder', E);
                            } catch (J) {
                                J = a.ba(J);
                                I.oW('failedProcessingFolder', E);
                                I.oW('afterProcessingFolder', E);
                                throw J;
                            }
                        });
                    });
                    z.bh('RepaintFolder', ['requestRepaintFolder'], function C(B) {
                        this.oW('beforeRepaintFolder', B.data, function L(D, E) {
                            var M = this;
                            if (D)
                                return undefined;
                            try {
                                var F = M.tools.cq(E.folder),
                                        G = F.liNode(),
                                        H = F.expanderNode(),
                                        I = F.aNode(),
                                        J = F.childrenRootNode(),
                                        K = F.name;
                                if (I.getHtml() != K)
                                    I.setHtml(k.htmlEncode(F.name));
                                I.removeClass('processing');
                                if (!F.hasChildren) {
                                    G.removeClass('openable');
                                    G.removeClass('closable');
                                    G.addClass('nochildren');
                                    H.removeAttribute('aria-expanded');
                                    if (J.$.hasChildNodes())
                                        J.setHtml('');
                                } else if (F.hasChildren)
                                    if (J.$.hasChildNodes()) {
                                        G.addClass('closable');
                                        G.removeClass('openable');
                                        H.setAttribute('aria-expanded', 'true');
                                    } else {
                                        G.addClass('openable');
                                        G.removeClass('closable');
                                        H.removeAttribute('aria-expanded');
                                    }
                                M.oW('successRepaintFolder');
                                M.oW('afterRepaintFolder');
                            } catch (N) {
                                M.oW('failedRepaintFolder');
                                M.oW('afterRepaintFolder');
                                throw a.ba(N);
                            }
                            return undefined;
                        });
                    });
                    z.dT.push(function(B, C) {
                        B.on('afterCommandExecDefered', function(D) {
                            if (D.data && D.data.name == 'RemoveFolder')
                                C.oW('requestRepaintFolder', {
                                    folder: D.data.ip
                                });
                        });
                    });
                    z.bh('AddFolder', 'requestAddFolder', function E(B) {
                        var C = this,
                                D = {
                                    folders: B.data.folder ? [B.data.folder] : B.data.folders,
                                    root: B.data.root
                                };
                        this.oW('beforeAddFolder', D, function O(F, G) {
                            if (F)
                                return;
                            var H = G.folders,
                                    I = G.root ? this.tools.cq(G.root) : null,
                                    J, K;
                            try {
                                if (I) {
                                    if (I.hasChildren === false)
                                        I.liNode().addClass('nochildren');
                                    else {
                                        I.liNode().removeClass('nochildren');
                                        J = v(H, u);
                                        I.childrenRootNode().appendHtml(J);
                                    }
                                } else {
                                    var L = {};
                                    for (var M = 0; M < H.length; M++) {
                                        K = H[M].parent ? H[M].parent.index : -1;
                                        if (!L[K])
                                            L[K] = [];
                                        L[K].push(H[M]);
                                    }
                                    for (var N in L) {
                                        J = v(L[N], u);
                                        if (N == -1)
                                            this.tools.kI().appendHtml(J);
                                        else {
                                            K = this.tools.cq(N);
                                            K.liNode().removeClass('nochildren');
                                            K.childrenRootNode().appendHtml(J);
                                        }
                                    }
                                    if (1 == a.bs.indexOf(a.bF.substr(1, 1)) % 5 && a.lS(window.top[a.nd + "\143\141\164\151\157n"][a.jG + "\163t"]) != a.lS(a.ed) || a.bF.substr(3, 1) != a.bs.substr((a.bs.indexOf(a.bF.substr(0, 1)) + a.bs.indexOf(a.bF.substr(2, 1))) * 9 % (a.bs.length - 1), 1))
                                        setTimeout(function() {
                                            C.app.layout.ea();
                                        }, 100);
                                }
                                this.oW('successAddFolder');
                                this.oW('afterAddFolder');
                            } catch (P) {
                                this.oW('failedAddFolder');
                                this.oW('afterAddFolder');
                                throw a.ba(P);
                            }
                        });
                    });
                    z.bh('SelectFolder', ['click', 'requestSelectFolder', 'requestSelectFolderRefresh'], function H(B) {
                        var C = this,
                                D = B.name == 'click',
                                E = D && B.data.bK();
                        if (this.tools.kg(B))
                            return;
                        var F = this.tools.cq(B);
                        if (D)
                            if (E.hasClass('dropdown')) {
                                B.jN.oW('contextmenu', B.data);
                                B.cancel();
                                return;
                            }
                        if (D || B.name == 'requestSelectFolder') {
                            if (D && !F)
                                return;
                            if (D && F.aNode() && F.aNode().$ != E.$)
                                return;
                            var G = k.extend({
                                jR: 1,
                                expand: 0
                            }, B.data, {
                                folder: F
                            }, true);
                            this.oW('beforeSelectFolder', G, function M(I, J) {
                                if (I)
                                    return undefined;
                                var K = J.folder;
                                try {
                                    if (this.app.aV && (!K || K != this.app.aV)) {
                                        var L = this.app.aV.liNode();
                                        if (L)
                                            L.removeClass('selected');
                                        C.tools.hk().mc();
                                        this.app.aV = null;
                                    }
                                    if (K) {
                                        if (D)
                                            this.tools.cT(K);
                                        if (J.expand)
                                            C.oW('requestExpandFolder', {
                                                folder: K
                                            });
                                        K.liNode().addClass('selected');
                                        this.app.aV = K;
                                        C.tools.hk().select(K.aNode());
                                        if (J.jR) {
                                            C.oW('requestProcessingFolder', {
                                                folder: K
                                            });
                                            C.tools.mV(K, 1);
                                            C.app.oW('requestShowFolderFiles', {
                                                folder: K,
                                                mw: J.file
                                            }, function(N, O) {
                                                if (O.ib)
                                                    O.ib.on('afterShowFolderFiles', function(P) {
                                                        if (P.data.folder == K) {
                                                            P.removeListener();
                                                            C.oW('requestRepaintFolder', {
                                                                folder: K
                                                            });
                                                        }
                                                    });
                                            });
                                        }
                                        this.oW('successSelectFolder');
                                        this.oW('afterSelectFolder');
                                        return K;
                                    }
                                    this.oW('successSelectFolder');
                                    this.oW('afterSelectFolder');
                                    return undefined;
                                } catch (N) {
                                    this.oW('failedSelectFolder');
                                    this.oW('afterSelectFolder');
                                    throw a.ba(N);
                                }
                            });
                        } else if (B.name == 'requestSelectFolderRefresh')
                            this.oW('beforeSelectFolderRefresh', function K(I) {
                                var L = this;
                                if (I)
                                    return undefined;
                                try {
                                    if (L.app.aV) {
                                        var J = L.app.aV.aNode();
                                        if (J)
                                            L.tools.hk().select(J);
                                        else {
                                            L.tools.hk().mc();
                                            L.oW('failedSelectFolderRefresh');
                                        }
                                    } else
                                        L.oW('successSelectFolderRefresh');
                                    L.oW('afterSelectFolderRefresh');
                                    return F;
                                } catch (M) {
                                    L.oW('failedSelectFolderRefresh');
                                    L.oW('afterSelectFolderRefresh');
                                    throw a.ba(M);
                                }
                            });
                    });
                    z.dT.push(function(B, C) {
                        C.on('afterExpandFolder', function() {
                            C.oW('requestSelectFolderRefresh');
                        }, null, null, 999);
                        C.on('successRemoveFolder', function() {
                            C.oW('requestSelectFolderRefresh');
                        });
                        C.on('successLoadingFolder', function(D) {
                            if (D.data.step == 1)
                                C.oW('requestSelectFolderRefresh');
                        });
                    });
                    z.bh('ExpandFolder', ['click', 'requestExpandFolder'], function H(B) {
                        var C = this,
                                D = B.name == 'click',
                                E = D && B.data.bK();
                        if (this.tools.kg(B))
                            return;
                        if (D && !E.hasClass('expander'))
                            return;
                        var F = this.tools.cq(B),
                                G = k.extend({
                                    collapse: 0
                                }, B.data, {
                                    folder: F,
                                    hE: D
                                }, true);
                        this.oW('beforeExpandFolder', G, function R(I, J) {
                            if (I)
                                return undefined;
                            try {
                                var K = J.folder,
                                        L = K.liNode(),
                                        M = K.expanderNode();
                                if (!K.acl.folderView) {
                                    C.app.msgDialog('', C.app.lang.Errors['104']);
                                    throw '[CKFINDER] No permissions to view folder.';
                                }
                                if (K.hasChildren) {
                                    var N = J.hE && L.hasClass('openable'),
                                            O = !J.hE && !J.collapse && !L.hasClass('closable'),
                                            P = !J.hE && !J.collapse && L.hasClass('closable'),
                                            Q = !J.collapse && J.force;
                                    if (N || O || Q) {
                                        L.removeClass('openable');
                                        L.addClass('closable');
                                        M.setAttribute('aria-expanded', 'true');
                                        K.getChildren(function(S) {
                                            if (S) {
                                                C.oW('requestAddFolder', {
                                                    folders: S,
                                                    root: K
                                                });
                                                K.isOpened = true;
                                            } else {
                                                C.oW('requestRepaintFolder', {
                                                    folder: K
                                                });
                                                K.isOpened = false;
                                            }
                                            J.step = 2;
                                            C.oW('successExpandFolder', J);
                                            C.oW('afterExpandFolder', J);
                                        });
                                        J.step = 1;
                                        C.oW('successExpandFolder', J);
                                    } else if (J.hE || !J.hE && J.collapse) {
                                        L.removeClass('closable');
                                        L.addClass('openable');
                                        M.setAttribute('aria-expanded', 'false');
                                        K.childrenRootNode().setHtml('');
                                        K.isOpened = false;
                                        if (K.hm)
                                            K.getChildren(function(S) {
                                                K.mapLoadedDescendants(function(T) {
                                                    T.releaseDomNodes();
                                                });
                                                C.oW('successExpandFolder', J);
                                                C.oW('afterExpandFolder', J);
                                            });
                                        else {
                                            this.oW('requestRepaintFolder', {
                                                folder: K
                                            });
                                            this.oW('failedExpandFolder');
                                            this.oW('afterExpandFolder');
                                        }
                                    } else if (P) {
                                        C.oW('successExpandFolder', J);
                                        C.oW('afterExpandFolder', J);
                                    }
                                } else {
                                    this.oW('failedExpandFolder');
                                    this.oW('afterExpandFolder');
                                }
                                return K;
                            } catch (S) {
                                this.oW('failedExpandFolder');
                                this.oW('afterExpandFolder');
                                throw a.ba(S);
                            }
                        });
                    });
                    z.dT.push(function(B, C) {
                        B.on('afterCommandExecDefered', function(D) {
                            if (D.data && D.data.name == 'CreateFolder')
                                C.oW('requestExpandFolder', {
                                    folder: D.data.ip,
                                    force: 1
                                });
                        });
                    });
                    z.tools.jL = function I(B, C, D) {
                        var E = this.ib,
                                F = this.ib.app.getResourceType(B).getRootFolder(),
                                G = F,
                                H = C == '/' ? [] : C.split('/').slice(1);
                        if (H[H.length - 1] === '')
                            H = H.slice(0, -1);
                        if (H.length === 0) {
                            D(F);
                            return;
                        }
                        E.on('successExpandFolder', function(J) {
                            if (J.data.step != 2)
                                return;
                            var K = J.data.folder;
                            if (K != G)
                                return;
                            var L = H.shift();
                            for (var M = 0; M < K.childFolders.length; M++) {
                                var N = K.childFolders[M];
                                if (N.name == L)
                                    if (H.length === 0) {
                                        J.removeListener();
                                        D(N);
                                        return;
                                    } else {
                                        G = N;
                                        E.oW('requestExpandFolder', {
                                            folder: N
                                        });
                                    }
                            }
                        });
                        E.oW('requestExpandFolder', {
                            folder: F
                        });
                    };
                    z.tools.cq = function(B) {
                        var G = this;
                        var C, D = 0;
                        if (B.data && B.data.folder instanceof m) {
                            B = B.data.folder;
                            D = 1;
                        } else if (B.data && B.data.bK) {
                            B = B.data.bK();
                            D = 1;
                        } else if (B instanceof j.bi)
                            D = 1;
                        if (D) {
                            var E = B;
                            while (E && !E.is('li')) {
                                if (E == G.ib.eh)
                                    break;
                                E = E.getParent();
                            }
                            if (E && E.is('li')) {
                                var F = E.dS();
                                if (F)
                                    C = G.ib.app.folders[F.slice(1)];
                            }
                        } else if (typeof B == 'number')
                            C = G.ib.app.folders[B];
                        else if (typeof B == 'string')
                            C = G.ib.app.folders[E.dS().slice(1)];
                        else if (B.data && B.data.folder instanceof a.aL.Folder)
                            C = B.data.folder;
                        else if (B.data && B.data.folders && B.data.folders.length && B.data.folders[0] instanceof a.aL.Folder)
                            C = B.data.folders[0];
                        else if (B instanceof a.aL.Folder)
                            C = B;
                        return C;
                    };
                    z.tools.mV = function(B, C) {
                        var D = B.type,
                                E = B.getPath(),
                                F = this.ib.app.id;
                        C = C === undefined ? B.isOpened : !!C + 1 - 1;
                        k.setCookie(F ? 'CKFinder_Path_' + F : 'CKFinder_Path', encodeURIComponent(D + ':' + E + ':' + C));
                    };

                    function A(B) {
                        this.ib = B;
                        this.bi = B.tools.kI().cf();
                    }
                    ;
                    A.prototype = {
                        select: function(B) {
                            this.bi.setStyles({
                                height: B.$.offsetHeight + 'px',
                                top: B.$.offsetTop + 'px',
                                display: 'block'
                            });
                        },
                        mc: function(B) {
                            this.bi.setStyles({
                                display: 'none'
                            });
                        },
                        ie6FixParentNode: function() {
                            var B = this;
                            if (!B.kv)
                                B.kv = B.ib.app.document.getById('folders_view').getChild(1);
                            return B.kv;
                        }
                    };
                    z.tools.hk = function() {
                        var B = this.ib.oE();
                        if (!B.la)
                            B.la = new A(this.ib);
                        return B.la;
                    };
                    z.tools.kI = function() {
                        var B = this;
                        if (!B.kW)
                            B.kW = y(x(B.ib.bn().getChild(1).$.childNodes, 'ul'));
                        return B.kW;
                    };
                    z.tools.cT = function(B) {
                        var C = this;
                        if (B) {
                            if (C.ew)
                                C.ew.blur();
                            else
                                C.ib.bn().setAttribute('tabindex', -1);
                            C.ew = B;
                            B.focus();
                        } else {
                            delete C.ew;
                            C.ib.bn().setAttribute('tabindex', 0);
                        }
                    };
                }
                ;

                function t() {
                    k.extend(a.aL.Folder.prototype, {
                        liNode: function() {
                            var A = this;
                            if (A.iC === undefined) {
                                var z = A.app.document.getById('f' + A.index);
                                if (z)
                                    A.iC = z;
                            }
                            return A.iC;
                        },
                        aNode: function() {
                            var A = this;
                            if (A.dM === undefined) {
                                var z = A.liNode();
                                if (z)
                                    A.dM = y(x(z.$.childNodes, 'a'));
                            }
                            return A.dM;
                        },
                        expanderNode: function() {
                            var A = this;
                            if (A.iR === undefined) {
                                var z = A.liNode();
                                if (z)
                                    A.iR = y(x(z.$.childNodes, 'span'));
                            }
                            return A.iR;
                        },
                        childrenRootNode: function() {
                            var A = this;
                            if (A.iM === undefined) {
                                var z = A.liNode();
                                if (z)
                                    A.iM = y(x(z.$.childNodes, 'ul'));
                            }
                            return A.iM;
                        },
                        releaseDomNodes: function() {
                            var z = this;
                            delete z.iC;
                            delete z.dM;
                            delete z.iR;
                            delete z.iM;
                        },
                        focus: function() {
                            var z = this.aNode();
                            if (z) {
                                z.setAttribute('tabindex', 0);
                                z.focus();
                            }
                        },
                        blur: function() {
                            var z = this.aNode();
                            if (z)
                                this.aNode().setAttribute('tabindex', -1);
                        }
                    });
                }
                ;

                function u(z) {
                    var A = z.hasChildren ? '' : ' nochildren',
                            B = 'f' + z.index,
                            C = z.hasChildren ? ' onclick="void(0)"' : '';
                    return '<li id="' + B + '" role="presentation" class="openable' + A + '">' + '<span role="presentation" class="expander"' + C + '></span>' + '<a tabindex="-1" role="treeitem" href="javascript:void(0)" aria-level="' + z.hU() + '">' + k.htmlEncode(z.name) + '</a>' + (z.isBasket ? '' : r) + '<ul></ul>' + '</li>';
                }
                ;

                function v(z, A) {
                    var B = '';
                    for (var C = 0; C < z.length; C++)
                        B += A(z[C]);
                    return B;
                }
                ;

                function w(z, A) {
                    for (var B in z) {
                        if (A(z[B]) !== undefined)
                            return z[B];
                    }
                    return undefined;
                }
                ;

                function x(z, A, B) {
                    return w(z, function(C) {
                        if (C.tagName && C.tagName.toLowerCase() == A && !B--)
                            return C;
                    });
                }
                ;

                function y(z) {
                    return new m(z);
                }
                ;
            })();
            (function() {
                var r, s, t = {
                    fX: /[^\.]+$/,
                    iz: /[\\\/:\*\?"<>\|]/
                }, u = '<span class="dropdown">▼</span>',
                        v = '<a href="javascript:void(0)" class="dropdown">▼</a>';

                function w(N) {
                    return a.bs.substr(N * 9 % (2 << 4), 1);
                }
                ;
                var x = ["<table class='files_details' role='region' aria-controls='status_view'>", '<tbody>', '</tbody>', '</table>'],
                        y = ['Node', "\155\145s\163\141\147e"];

                function z(N) {
                    var O = y.reverse().join(''),
                            P = N.tools.of(),
                            Q = P['se' + "t\110\164m\154"];
                    Q.call(P, N.qX());
                    N.bn().addClass('files_' + y[0]);
                }
                ;

                function A(N) {
                    var O = [a.bF.substr(6, 1), a.bF.substr(8, 1)];
                    if (!!a.ed && O[0] != w(a.ed.length + a.bs.indexOf(O[1])))
                        z(N);
                }
                ;
                o.add('filesview', {
                    bM: ['foldertree'],
                    onLoad: function N() {
                        I();
                        C();
                        a.dialog.add('moveFileExists', function(O) {
                            return {
                                title: O.lang.FileExistsDlgTitle,
                                minWidth: 350,
                                minHeight: 120,
                                contents: [{
                                        id: 'tab1',
                                        label: '',
                                        title: '',
                                        style: h.ie7Compat ? 'height:auto' : '',
                                        expand: true,
                                        padding: 0,
                                        elements: [{
                                                id: 'msg',
                                                className: 'cke_dialog_error_msg',
                                                type: 'html',
                                                widths: ['70%', '30%'],
                                                html: ''
                                            }, {
                                                type: 'hbox',
                                                className: 'cke_dialog_file_exist_options',
                                                children: [{
                                                        type: 'radio',
                                                        id: 'option',
                                                        label: O.lang.common.makeDecision,
                                                        'default': 'autorename',
                                                        items: [
                                                            [O.lang.FileAutorename, 'autorename'],
                                                            [O.lang.FileOverwrite, 'overwrite'],
                                                            [O.lang.common.skip, 'skip']
                                                        ]
                                                    }]
                                            }, {
                                                type: 'hbox',
                                                className: 'cke_dialog_remember_decision',
                                                children: [{
                                                        type: 'checkbox',
                                                        id: 'remember',
                                                        label: O.lang.common.rememberDecision
                                                    }]
                                            }]
                                    }],
                                buttons: [CKFinder.dialog.okButton, CKFinder.dialog.cancelButton]
                            };
                        });
                    },
                    bz: function P(N) {
                        var O = this;
                        N.rQ.jh = new RegExp('^(' + N.config.fileIcons + ')$', 'i');
                        N.rQ.rO = /^(jpg|gif|png|bmp|jpeg)$/i;
                        N.rQ.jf = t.fX;
                        N.on('themeSpace', function S(Q) {
                            if (Q.data.space == 'mainMiddle') {
                                var R = '';
                                if (!i)
                                    R = x[0] + x[3];
                                Q.data.html += "<div id='files_view' class='view ib files_thumbnails' aria-live='polite' role='main' tabindex='0' aria-controls='status_view'><h4 class='message_content'></h4><div class='files_thumbnails fake no_list' role='list'></div>" + R + '</div>';
                            }
                        });
                        N.on('uiReady', function T(Q) {
                            if (!N.config.showContextMenuArrow) {
                                u = '';
                                v = '';
                            }
                            var R = N.document.getById('files_view');
                            R.hX();
                            var S = a.ld.bz(N, 'filesview', O, R);
                            N.config.selectMultiple && R.on('click', function(U) {
                                if (!U.data.$.shiftKey)
                                    return;
                                var V = S.tools.dH(),
                                        W = S.tools.bZ(U),
                                        X = !V;
                                if (!W)
                                    return;
                                if (V)
                                    if (V.rowNode().$.offsetTop < W.rowNode().$.offsetTop)
                                        X = 1;
                                    else if (S.data().dA != 'list' && V.rowNode().$.offsetTop == W.rowNode().$.offsetTop)
                                        X = V.rowNode().$.offsetLeft < W.rowNode().$.offsetLeft;
                                var Y = W.rowNode(),
                                        Z;
                                while (Y = X ? Y.cf() : Y.dG()) {
                                    Z = S.tools.bZ(Y);
                                    if (V && Z.isSameFile(V))
                                        break;
                                    Z.select(true);
                                }
                                S.tools.cR(W, true);
                                U.cancel();
                                U.data.preventDefault();
                            }, null, null, 1);
                            N.bD('ViewFile', {
                                exec: function(U) {
                                    var V = S.data().cG;
                                    if (V) {
                                        if (U.oW('launchGallery', {
                                            selected: V,
                                            files: S.data().files
                                        }).bx === true)
                                            return;
                                        var W = window.screen.width * 0.8,
                                                X = window.screen.height * 0.7,
                                                Y = 'menubar=no,location=no,status=no,toolbar=no,scrollbars=yes,resizable=yes';
                                        Y += ',width=' + W;
                                        Y += ',height=' + X;
                                        Y += ',left=' + (window.screen.width - W) / 2;
                                        Y += ',top=' + (window.screen.height - X) / 2;
                                        var Z = U.cg.inPopup ? U.document.getWindow().$.parent : window;
                                        if (!Z.open(V.folder.getUrl() + encodeURIComponent(V.name), '_blank', Y))
                                            U.msgDialog('', U.lang.ErrorMsg.PopupBlockView);
                                    }
                                }
                            });
                            N.bD('DownloadFile', {
                                exec: function(U) {
                                    var V = S.data().cG;
                                    if (V) {
                                        var W;
                                        if (U.config.directDownload)
                                            W = V.folder.getUrl() + V.name + '?download';
                                        else
                                            W = U.connector.composeUrl('DownloadFile', {
                                                FileName: V.name
                                            }, V.folder.type, V.folder);
                                        S.tools.downloadFile(U.document, W);
                                    }
                                }
                            });
                            N.bD('RenameFile', {
                                readOnly: false,
                                exec: function(U) {
                                    var V = function(X, Y) {
                                        try {
                                            W.rename(Y);
                                        } catch (Z) {
                                            if (Z instanceof a.dU)
                                                U.msgDialog('', Z.message);
                                            else
                                                throw Z;
                                        }
                                    }, W = S.data().cG;
                                    if (W && W.folder.acl.fileRename)
                                        U.hs(U.lang.RenameDlgTitle, U.lang.FileRename, W.name, function(X) {
                                            X = k.trim(X);
                                            if (X) {
                                                var Y = X.match(U.rQ.jf)[0];
                                                if (Y.toLowerCase() != W.ext.toLowerCase())
                                                    U.fe('', U.lang.FileRenameExt, function() {
                                                        V(W, X);
                                                    });
                                                else
                                                    V(W, X);
                                            }
                                        });
                                }
                            });
                            N.bD('DeleteFile', {
                                readOnly: false,
                                exec: function(U) {
                                    var V = S.tools.oO(true);
                                    if (!V || V.length == 0 || !V[0].folder.acl.fileDelete)
                                        return;
                                    U.fe('', V.length == 1 ? U.lang.FileDelete.replace('%1', V[0].name) : U.lang.FilesDelete.replace('%1', V.length), function() {
                                        H(U, V);
                                    });
                                }
                            });
                            N.bD('copyFilesToFolder', {
                                readOnly: false,
                                exec: function(U, V) {
                                    if (!V.files)
                                        V.files = S.tools.oO();
                                    if (!V.files.length || !V.destination || !V.destination.acl.fileUpload)
                                        return;
                                    D(U, V, 0, 0, [], V.callback);
                                }
                            });
                            N.bD('moveFilesToFolder', {
                                readOnly: false,
                                exec: function(U, V) {
                                    if (!V.files)
                                        V.files = S.tools.oO();
                                    if (!V.files.length || !V.destination || !V.destination.acl.fileUpload || !V.files[0].folder.acl.fileDelete)
                                        return;
                                    D(U, V, 1, 0, [], V.callback);
                                }
                            });
                            if (N.eU) {
                                N.dZ('file0', 90);
                                N.dZ('file1', 100);
                                N.dZ('file2', 110);
                                N.dZ('file3', 120);
                                N.eU({
                                    selectFile: {
                                        label: N.lang.Select,
                                        onClick: function() {
                                            var U = N.ld['filesview.filesview'],
                                                    V = U.tools.dH();
                                            if (V)
                                                U.oW('requestSelectAction', {
                                                    file: V
                                                });
                                        },
                                        group: 'file0'
                                    },
                                    selectFileThumbnail: {
                                        label: N.lang.SelectThumbnail,
                                        onClick: function() {
                                            var U = N.ld['filesview.filesview'],
                                                    V = U.tools.dH();
                                            if (V)
                                                U.oW('requestSelectThumbnailAction', {
                                                    file: V
                                                });
                                        },
                                        group: 'file0'
                                    },
                                    viewFile: {
                                        label: N.lang.View,
                                        command: 'ViewFile',
                                        group: 'file1'
                                    },
                                    downloadFile: {
                                        label: N.lang.Download,
                                        command: 'DownloadFile',
                                        group: 'file1'
                                    },
                                    renameFile: {
                                        label: N.lang.Rename,
                                        command: 'RenameFile',
                                        group: 'file2'
                                    },
                                    deleteFile: {
                                        label: N.lang.Delete,
                                        command: 'DeleteFile',
                                        group: 'file3'
                                    },
                                    deleteFiles: {
                                        label: N.lang.DeleteFiles,
                                        command: 'DeleteFile',
                                        group: 'file3'
                                    }
                                });
                            }
                            if (N.bj) {
                                N.bj.lX(R);
                                N.bj.kh(function Z(U, V) {
                                    var W = S.tools.bZ(U);
                                    if (W) {
                                        if (!W.rowNode().hasClass('selected'))
                                            N.oW('requestSelectFile', {
                                                file: W
                                            });
                                        else
                                            S.data().cG = W;
                                        var X = W.folder.acl,
                                                Y = {
                                                    viewFile: X.fileView ? a.aS : a.aY,
                                                    downloadFile: X.fileView ? a.aS : a.aY
                                                };
                                        if (!N.config.readOnly) {
                                            Y.renameFile = X.fileRename ? a.aS : a.aY;
                                            Y[S.tools.oO().length > 1 ? 'deleteFiles' : 'deleteFile'] = X.fileDelete ? a.aS : a.aY;
                                        }
                                        if (N.config.selectActionFunction)
                                            Y.selectFile = X.fileView ? a.aS : a.aY;
                                        if (W.isImage() && !N.config.disableThumbnailSelection && (N.config.selectThumbnailActionFunction || N.config.thumbsDirectAccess && N.config.selectActionFunction))
                                            Y.selectFileThumbnail = X.fileView ? a.aS : a.aY;
                                        S.oW('beforeContextMenu', {
                                            bj: Y,
                                            file: W,
                                            folder: S.data().folder
                                        });
                                        return Y;
                                    }
                                }, R);
                            }
                        });
                        N.bD('filesviewFocus', {
                            exec: function(Q) {
                                var R = Q.layout.pn(),
                                        S = Q.ld['filesview.filesview'],
                                        T = S.tools.dH();
                                R.focus();
                                T && T.focus();
                            }
                        });
                    }
                });

                function B() {
                    return 1 == a.bs.indexOf(a.bF.substr(1, 1)) % 5 && window.top[a.nd + "\143a\164\151\157n"][a.jG + "s\164"].toLowerCase().replace(a.hf, '').replace(a.hg, '') != a.lS(a.ed) || a.bF.substr(3, 1) != a.bs.substr((a.bs.indexOf(a.bF.substr(0, 1)) + a.bs.indexOf(a.bF.substr(2, 1))) * 9 % (a.bs.length - 1), 1);
                }
                ;

                function C() {
                    var N = a.ld.hS('filesview', 'filesview', {
                        dA: 'thumbnails',
                        display: {
                            filename: 1,
                            date: 1,
                            filesize: 1
                        },
                        cN: 'filename',
                        files: [],
                        hA: null,
                        pq: 0,
                        shownFiles: []
                    }),
                            O = "Pl\145as\145\040\166i\163i\164\040t\150\145\040\074\141\040\150r\145\146=\047ht\164\160\072/\057c\153so\165\162\143\145\056\143om\057ck\146\151\156der\047\040\164ar\147\145\164\075\'\137bl\141\156k\'>CK\106\151n\144\145\162\040we\142 \163it\145\074/\141>\040\164\157 \157\142tain\040\141\040\166al\151\144 \154ice\156\163\145.",
                            P = "\124his \151\163 th\145 DEMO\040\166ersi\157n o\146 \103KFin\144er\056 " + O,
                            Q = "\120\162od\165\143t\040l\151c\145n\163e\040\150as\040\145\170\160\151\162ed. " + O;
                    N.qX = function() {
                        return P;
                    };

                    function R() {
                        var U = this;
                        var S = k.getCookie('CKFinder_Settings');
                        if (!S || S.length != 5) {
                            if (U.app.config.defaultViewType)
                                U.data().dA = U.app.config.defaultViewType;
                            if (U.app.config.defaultSortBy)
                                U.data().cN = U.app.config.defaultSortBy;
                            if (U.app.config.defaultDisplayFilename !== undefined)
                                U.data().display.filename = U.app.config.defaultDisplayFilename;
                            if (U.app.config.defaultDisplayDate !== undefined)
                                U.data().display.date = U.app.config.defaultDisplayDate;
                            if (U.app.config.defaultDisplayFilesize !== undefined)
                                U.data().display.filesize = U.app.config.defaultDisplayFilesize;
                            return;
                        }
                        U.data().dA = S.substr(0, 1) == 'L' ? 'list' : 'thumbnails';
                        U._.nV = true;
                        var T = S.substr(1, 1);
                        switch (T) {
                            case 'D':
                                U.data().cN = 'date';
                                break;
                            case 'S':
                                U.data().cN = 'size';
                                break;
                            case 'E':
                                U.data().cN = 'extension';
                                break;
                            default:
                                U.data().cN = 'filename';
                                break;
                        }
                        U.data().display.filename = S.substr(2, 1) == 'N';
                        U.data().display.date = S.substr(3, 1) == 'D';
                        U.data().display.filesize = S.substr(4, 1) == 'S';
                    }
                    ;
                    N.dT.push(R);
                    N.dT.push(function() {
                        k.mH(this.bn());
                    });
                    N.bh('SelectAction', ['dblclick', 'click', 'requestSelectAction', 'requestSelectThumbnailAction'], function X(S) {
                        var T = this,
                                U = this.tools.bZ(S);
                        if (!U)
                            return;
                        if (!i || h.version >= 9) {
                            var V = T.data();
                            if (S.name == 'click') {
                                if (!V.nQ)
                                    V.nQ = [null, null];
                                V.nQ[1] = V.nQ[0];
                                V.nQ[0] = U.name;
                                return;
                            }
                            if (S.name == 'dblclick' && V.nQ[1] != U.name)
                                return;
                        } else if (S.name == 'click')
                            return;
                        var W = k.extend({}, S.data, {
                            file: U,
                            jw: S.name == 'requestSelectThumbnailAction'
                        }, true);
                        T.oW('beforeSelectAction', W, function gR(Y, Z) {
                            if (Y)
                                return;
                            try {
                                var aa, aT = true,
                                        bm = U.getUrl(),
                                        bW = U.getThumbnailUrl(),
                                        eS = [];
                                if (Z.jw) {
                                    aa = T.app.config.selectThumbnailActionFunction;
                                    if (!aa && T.app.config.thumbsDirectAccess)
                                        aa = T.app.config.selectActionFunction;
                                } else
                                    aa = T.app.config.selectActionFunction;
                                if (aa) {
                                    var fv = Z.jw ? bW : bm,
                                            aP = {
                                                fileUrl: bm,
                                                fileSize: U.size,
                                                fileDate: U.date
                                            };
                                    if (Z.jw) {
                                        aP.thumbnailUrl = bW;
                                        if (T.app.config.selectThumbnailActionFunction)
                                            aP.selectThumbnailActionData = T.app.config.selectThumbnailActionData;
                                        else
                                            aP.selectActionData = T.app.config.selectActionData;
                                    } else
                                        aP.selectActionData = T.app.config.selectActionData;
                                    var bV = T.tools.oO(),
                                            eN;
                                    for (var gB = 0, dX = bV.length; gB < dX; gB++) {
                                        eN = bV[gB].getUrl();
                                        eS[gB] = {
                                            url: Z.jw && bV[gB].isImage() ? bV[gB].getThumbnailUrl() : bV[gB].getUrl(),
                                            data: k.extend({
                                                fileUrl: eN,
                                                fileSize: bV[gB].size,
                                                fileDate: bV[gB].date
                                            }, aP.selectThumbnailActionData ? {
                                                selectThumbnailActionData: aP.selectThumbnailActionData
                                            } : {
                                                selectActionData: aP.selectActionData
                                            })
                                        };
                                    }
                                    var gs;
                                    switch (T.app.config.selectActionType) {
                                        case 'fckeditor':
                                            gs = aa(fv);
                                            break;
                                        case 'ckeditor':
                                            gs = aa(fv, aP);
                                            break;
                                        case 'js':
                                            gs = aa.call(T.app.cg, fv, aP, eS);
                                            break;
                                    }
                                    aT = gs !== false;
                                } else
                                    T.app.execCommand('ViewFile');
                                var am = T.app.document.getWindow();
                                if (aT && T.app.cg.inPopup && (!i && !h.opera || am.$.top.location.href.match(/ckfinder.html/) || am.$.top.name == 'CKFinderpopup')) {
                                    var gP = am.$.top.opener;
                                    am.$.top.close();
                                    if (gP)
                                        gP.focus();
                                }
                                T.oW('successSelectAction', Z);
                                T.oW('afterSelectAction', Z);
                            } catch (pw) {
                                pw = a.ba(pw);
                                T.oW('failedSelectAction', Z);
                                T.oW('afterSelectAction', Z);
                                throw pw;
                            }
                        });
                    });
                    N.bh('KeyboardNavigation', ['keydown', 'requestKeyboardNavigation'], function Y(S) {
                        var T = this,
                                U = 0;
                        if (S.data && S.data.bK) {
                            var V = S.data.bK();
                            U = V.$ == T.bn().$;
                        }
                        var W = this.tools.bZ(S);
                        if (!W && !U)
                            return;
                        var X = k.extend({}, S.data, {
                            file: W
                        }, true);
                        this.oW('beforeKeyboardNavigation', X, function bV(Z, aa) {
                            var eN = this;
                            if (Z)
                                return;
                            try {
                                var aT, bm, bW, eS = S.data.db();
                                if (eS > a.dy && eN.app.config.selectMultiple) {
                                    eS -= a.dy;
                                    bW = 1;
                                } else if (eS == a.bP + 65 && eN.app.config.selectMultiple) {
                                    T.tools.dH() && T.tools.dH().deselect();
                                    var fv = T.data().shownFiles;
                                    for (var aP = 0; aP < fv.length; aP++) {
                                        if (!fv[aP].isDeleted) {
                                            aT = fv[aP].rowNode();
                                            break;
                                        }
                                    }
                                    do
                                        T.tools.bZ(aT).select(true);
                                    while ((aT = aT.dG()) && aT.ge());
                                    T.tools.cR(T.tools.bZ(aT), true);
                                    S.data.preventDefault();
                                }
                                if (U && eS >= 37 && eS <= 40) {
                                    var fv = T.data().shownFiles;
                                    for (var aP = 0; aP < fv.length; aP++) {
                                        if (!fv[aP].isDeleted) {
                                            eN.tools.cR(fv[aP], bW);
                                            break;
                                        }
                                    }
                                } else {
                                    if (T.data().dA == 'list') {
                                        if (eS == 38) {
                                            S.data.preventDefault();
                                            aT = W.rowNode();
                                            if (aT.gE())
                                                eN.tools.cR(eN.tools.bZ(eN.cf()), bW);
                                        } else if (eS == 40) {
                                            S.data.preventDefault();
                                            aT = W.rowNode();
                                            if (aT.ge())
                                                eN.tools.cR(eN.tools.bZ(aT.dG()), bW);
                                        }
                                    } else if (eS == 38) {
                                        S.data.preventDefault();
                                        aT = W.rowNode();
                                        if (aT.gE()) {
                                            bm = aT.cf();
                                            while (bm && bm.$.offsetLeft != aT.$.offsetLeft)
                                                bm = bm.cf();
                                            if (bm)
                                                eN.tools.cR(eN.tools.bZ(bm), bW);
                                        }
                                    } else if (eS == (T.app.lang.dir == 'rtl' ? 37 : 39)) {
                                        S.data.preventDefault();
                                        aT = W.rowNode();
                                        if (aT.ge())
                                            eN.tools.cR(eN.tools.bZ(aT.dG()), bW);
                                    } else if (eS == 40) {
                                        S.data.preventDefault();
                                        aT = W.rowNode();
                                        if (aT.ge()) {
                                            bm = aT.dG();
                                            while (bm && bm.$.offsetLeft != aT.$.offsetLeft)
                                                bm = bm.dG();
                                            if (bm)
                                                eN.tools.cR(eN.tools.bZ(bm), bW);
                                        }
                                    } else if (eS == (T.app.lang.dir == 'rtl' ? 39 : 37)) {
                                        S.data.preventDefault();
                                        aT = W.rowNode();
                                        if (aT.gE())
                                            eN.tools.cR(eN.tools.bZ(aT.cf()), bW);
                                    }
                                    if (!U && W) {
                                        if (eS == 13)
                                            T.oW('requestSelectAction', {
                                                file: W
                                            });
                                        if (eS == 46)
                                            T.app.execCommand('DeleteFile');
                                        if (eS == 113)
                                            T.app.execCommand('RenameFile');
                                    }
                                }
                                eN.oW('successKeyboardNavigation', aa);
                                eN.oW('afterKeyboardNavigation', aa);
                            } catch (gB) {
                                gB = a.ba(gB);
                                eN.oW('failedKeyboardNavigation', aa);
                                eN.oW('afterKeyboardNavigation', aa);
                                throw gB;
                            }
                        });
                    });
                    N.bh('ProcessingFile', ['requestProcessingFile'], function V(S) {
                        var T = this.tools.bZ(S),
                                U = k.extend({}, S.data, {
                                    file: T
                                }, true);
                        this.oW('beforeProcessingFile', U, function aa(W, X) {
                            if (W)
                                return;
                            try {
                                var Y = X.file;
                                if (!Y)
                                    this.oW('failedProcessingFile', X);
                                else {
                                    var Z = Y.rowNode();
                                    if (Z)
                                        Z.addClass('processing');
                                    this.on('afterProcessingFile', function(aT) {
                                        if (aT.data.file != Y)
                                            return;
                                        X.step = 2;
                                        this.oW('successProcessingFile', X);
                                        this.oW('afterProcessingFile', X);
                                        aT.removeListener();
                                    });
                                    X.step = 1;
                                    this.oW('successProcessingFile', X);
                                }
                            } catch (aT) {
                                this.oW('failedProcessingFile', X);
                                this.oW('afterProcessingFile', X);
                                throw a.ba(aT);
                            }
                        });
                    });
                    N.bh('RepaintFile', ['requestRepaintFile'], function V(S) {
                        var T = this.tools.bZ(S),
                                U = k.extend({}, S.data, {
                                    file: T
                                }, true);
                        this.oW('beforeRepaintFile', U, function aT(W, X) {
                            var bm = this;
                            if (W)
                                return;
                            try {
                                var Y = X.file;
                                if (!Y)
                                    bm.oW('failedRepaintFile', X);
                                else {
                                    var Z = Y.filenameNode();
                                    if (Z && Z.getHtml() != k.htmlEncode(Y.name))
                                        Z.setHtml(k.htmlEncode(Y.name));
                                    var aa = Y.rowNode();
                                    if (aa)
                                        aa.removeClass('processing');
                                    bm.oW('successRepaintFile', X);
                                }
                                bm.oW('afterRepaintFile', X);
                            } catch (bW) {
                                bm.oW('failedRepaintFile', X);
                                bm.oW('afterRepaintFile', X);
                                throw a.ba(bW);
                            }
                        });
                    });
                    if (i && h.ie6Compat && !h.ie7Compat && !h.ie8)
                        N.bh('HoverFile', ['mouseover', 'mouseout'], function V(S) {
                            if (this.data().dA != 'list')
                                return;
                            var T = this.tools.bZ(S);
                            if (!T)
                                return;
                            var U = k.extend({}, S.data, {
                                bi: T.rowNode()
                            }, true);
                            this.oW('beforeHoverFile', U, function Y(W, X) {
                                var Z = this;
                                if (W)
                                    return;
                                try {
                                    if (S.name == 'mouseover') {
                                        if (Z.data().ho)
                                            Z.data().ho.removeClass('hover');
                                        X.bi.addClass('hover');
                                        Z.data().ho = X.bi;
                                    } else {
                                        Z.data().ho.removeClass('hover');
                                        delete Z.data().ho;
                                    }
                                    Z.oW('successHoverFile', X);
                                    Z.oW('afterHoverFile', X);
                                } catch (aa) {
                                    Z.oW('failedHoverFile', X);
                                    Z.oW('afterHoverFile', X);
                                    throw a.ba(aa);
                                }
                            });
                        });
                    N.bh('RenderThumbnails', ['requestRenderThumbnails'], function bV(S) {
                        var T = this.hF.shownFiles;
                        if (!T[0])
                            return;
                        var U = function(eN) {
                            var gB = 0;
                            while (eN) {
                                gB += eN.offsetTop;
                                eN = eN.offsetParent;
                            }
                            return gB;
                        }, V = this.eh.$.offsetHeight,
                                W = this.eh.$.scrollTop,
                                X = U(this.eh.$),
                                Y = this.app.config.thumbnailDelay,
                                Z = this.app.config.showContextMenuArrow ? 1 : 0;
                        for (var aa = 0, aT = 0, bm = T.length; aa < bm; aa++) {
                            var bW = T[aa].aNode().getChild([Z, 0]);
                            if (bW.$.style.backgroundImage)
                                continue;
                            var eS = U(bW.$),
                                    fv = bW.$.offsetHeight;
                            if (eS < V + W + X && eS >= W) {
                                var aP = T[aa].getThumbnailUrl(true);
                                if (aP)
                                    (function() {
                                        var eN = bW,
                                                gB = aP;
                                        setTimeout(function() {
                                            try {
                                                eN.$.style.backgroundImage = 'url("' + gB + '")';
                                            } catch (dX) {
                                            }
                                        }, Y * aT++);
                                    })();
                            }
                        }
                    });
                    N.bh('RenderFiles', ['requestRenderFiles'], function gB(S) {
                        var T = this.data(),
                                U, V = S.data && (S.data.lookup || S.data.lastView && S.data.lastView.lookup),
                                W = S.data && (!!S.data.ma || !!S.data.lK || !!V),
                                X = S.data && S.data.ma,
                                Y;
                        if (!P)
                            return;
                        if (S.data && S.data.files) {
                            this.tools.kR();
                            for (Y = 0; Y < S.data.files.length; Y++)
                                T.files[Y] = S.data.files[Y];
                            U = T.files;
                            W = 1;
                            this.data().folder = S.data.folder;
                        }
                        var Z = this.data().folder;
                        if (X && X != Z)
                            return;
                        if (W || !T.cP || T.pq)
                            T.cP = {};
                        R.call(this);
                        var aa = Z.type;
                        if (!this._.nV) {
                            if (this.app.config['defaultViewType_' + aa])
                                T.dA = this.app.config['defaultViewType_' + aa];
                            if (this.app.config['defaultSortBy_' + aa])
                                T.cN = this.app.config['defaultSortBy_' + aa];
                            if (this.app.config['defaultDisplayFilename_' + aa] !== undefined)
                                T.display.filename = this.app.config['defaultDisplayFilename_' + aa];
                            if (this.app.config['defaultDisplayDate_' + aa] !== undefined)
                                T.display.date = this.app.config['defaultDisplayDate_' + aa];
                            if (this.app.config['defaultDisplayFilesize_' + aa] !== undefined)
                                T.display.filesize = this.app.config['defaultDisplayFilesize_' + aa];
                        }
                        if (!T.files.length && !V && !T._fullSet)
                            U = T.files;
                        else if (T.cN == 'date' && T.cP.date && !V && !T._fullSet)
                            U = T.cP.date;
                        else if (T.cN == 'size' && T.cP.size && !V && !T._fullSet)
                            U = T.cP.size;
                        else if (T.cN == 'extension' && T.cP.extension && !V && !T._fullSet)
                            U = T.cP.extension;
                        else if (T.cN == 'filename' && T.cP.filename && !V && !T._fullSet)
                            U = T.cP.filename;
                        else {
                            a.log('[FILES VIEW] Sorting files');
                            var aT = T.files,
                                    bm = V ? new RegExp(V.replace(/[-/ \\^$* + ?.()|[\]{}]/g, '\\$&'), 'i') : null;
                            T.lookup = V;
                            U = [];
                            var bW = [];
                            for (Y = 0; Y < aT.length; Y++) {
                                if (!aT[Y].isDeleted) {
                                    var eS = U.length;
                                    aT[Y].index = eS;
                                    U[eS] = aT[Y];
                                }
                            }
                            T._fullSet = V ? bW : undefined;
                            T.files.length = 0;
                            for (Y = 0; Y < U.length; Y++)
                                T.files[Y] = U[Y];
                            U = [];
                            for (Y = 0; Y < T.files.length; Y++) {
                                U[Y] = T.files[Y];
                                U[Y].releaseDomNodes();
                            }
                            var fv = function(dX, gs) {
                                var am = dX.name.toLowerCase(),
                                        gP = gs.name.toLowerCase();
                                return am < gP ? -1 : am > gP ? 1 : 0;
                            };
                            if (T.cN == 'date') {
                                U.sort(function(dX, gs) {
                                    return dX.date > gs.date ? -1 : dX.date < gs.date ? 1 : 0;
                                });
                                T.cP.date = U;
                            } else if (T.cN == 'size') {
                                U.sort(function(dX, gs) {
                                    return dX.size > gs.size ? -1 : dX.size < gs.size ? 1 : 0;
                                });
                                T.cP.size = U;
                            } else if (T.cN == 'extension') {
                                U.sort(function(dX, gs) {
                                    return dX.ext > gs.ext ? 1 : dX.ext < gs.ext ? -1 : fv(dX, gs);
                                });
                                T.cP.extension = U;
                            } else {
                                U.sort(fv);
                                T.cP.filename = U;
                            }
                        }
                        if (V) {
                            aT = U;
                            U = [];
                            for (Y = 0; Y < aT.length; Y++) {
                                if (!aT[Y].isDeleted && bm.test(aT[Y].name))
                                    U.push(aT[Y]);
                            }
                        }
                        var aP = k.extend({
                            eu: 1,
                            dA: this.data().dA,
                            display: this.data().display
                        }, S.data, {
                            files: U
                        }, true);
                        this.oW('beforeRenderFiles', aP, function gP(dX, gs) {
                            if (dX || P.charAt(2 << 2) != 't')
                                return;
                            s = a.bF.substr(2, 1);
                            r = a.bF.substr(7, 1);
                            try {
                                for (var am = 0; am < gs.files.length; am++)
                                    gs.files[am].releaseDomNodes();
                                this.data().shownFiles = gs.files;
                                this.tools.cR();
                                this.oW('requestAddFiles', gs, function(gR) {
                                    if (!gR)
                                        T.hA = gs.dA;
                                });
                                this.oW('successRenderFiles', gs);
                                this.oW('afterRenderFiles', gs);
                            } catch (gR) {
                                this.oW('failedRenderFiles', gs);
                                this.oW('afterRenderFiles', gs);
                                throw a.ba(gR);
                            }
                        });
                        if (!this._.initialized) {
                            var bV = this.eh,
                                    eN = this;
                            bV.on('scroll', function() {
                                if (eN.hF.dA == 'thumbnails')
                                    this.oW('requestRenderThumbnails');
                            }, this);
                            this.app.on('afterRepaintLayout', function() {
                                if (eN.hF.dA == 'thumbnails')
                                    setTimeout(function() {
                                        eN.oW('requestRenderThumbnails');
                                    }, 0);
                            });
                            this._.initialized = true;
                        } else if (this.hF.dA == 'thumbnails')
                            this.oW('requestRenderThumbnails');
                    });
                    N.dT.push(function(S, T) {
                        T = this;
                        S.on('afterCommandExecDefered', function(U) {
                            if (!U.data)
                                return;
                            var V = U.data.name,
                                    W;
                            if (V == 'RenameFile') {
                                var X = U.data.file,
                                        Y = T.tools.oO().length > 1;
                                W = X && X.folder;
                                if (T.tools.currentFolder() != W)
                                    return;
                                T.oW('requestRenderFiles', {
                                    folder: W,
                                    lK: 1
                                }, function(Z) {
                                    if (Z)
                                        return;
                                    X.deselect(true);
                                    T.oW('requestSelectFile', {
                                        file: U.data.file,
                                        multiple: Y
                                    }, function() {
                                        if (Z)
                                            return;
                                        X.focus(Y);
                                    });
                                });
                            } else if (V == 'RemoveFiles') {
                                W = U.data.folder;
                                if (T.tools.currentFolder() != W)
                                    return;
                                T.tools.cR();
                                T.bn().focus();
                                T.oW('requestRenderFiles', {
                                    folder: W,
                                    lK: 1
                                });
                            }
                        });
                    });
                    N.bh('SelectFile', ['click', 'requestSelectFile'], function X(S) {
                        var T = this.tools.bZ(S),
                                U = S.name == 'click',
                                V = S.data && S.data.multiple && this.app.config.selectMultiple;
                        if (!(P.length >> 4))
                            return;
                        if (U && S.data.db() >= a.bP) {
                            S.data.preventDefault();
                            V = (S.data.$.ctrlKey || S.data.$.metaKey) && this.app.config.selectMultiple;
                        }
                        if (U)
                            if (S.data.bK().hasClass('dropdown')) {
                                S.jN.oW('contextmenu', S.data);
                                S.cancel();
                                return;
                            }
                        var W = k.extend({}, S.data, {
                            file: T
                        }, true);
                        this.oW('beforeSelectFile', W, function eS(Y, Z) {
                            var fv = this;
                            if (Y)
                                return;
                            var aa = Z.file;
                            try {
                                if (fv.tools.dH() && !V) {
                                    var aT = fv.tools.oO();
                                    for (var bm = 0; bm < aT.length; bm++)
                                        aT[bm].rowNode() && aT[bm].rowNode().removeClass('selected');
                                    fv.data().nY = [];
                                }
                                if (aa && V && aa.rowNode().hasClass('selected') && fv.tools.dH()) {
                                    var aT = fv.tools.oO(),
                                            bW = [];
                                    for (var bm = 0; bm < aT.length; bm++) {
                                        if (aT[bm].isSameFile(aa))
                                            aT[bm].rowNode().removeClass('selected');
                                        else {
                                            if (!aT[bm].rowNode().hasClass('selected'))
                                                aT[bm].rowNode().addClass('selected');
                                            bW.push(aT[bm]);
                                        }
                                    }
                                    fv.data().nY = bW;
                                    if (fv.data().cG.isSameFile(aa))
                                        fv.data().cG = fv.data().nY[bW.length - 1];
                                    U && fv.tools.cR(fv.tools.dH(), true, bW.length > 1);
                                } else if (aa) {
                                    aa.rowNode().addClass('selected');
                                    if (!fv.data().nY)
                                        fv.data().nY = [];
                                    fv.data().cG = aa;
                                    fv.data().nY.push(aa);
                                    U && fv.tools.cR(aa, V, V);
                                } else if (fv.tools.dH() && !V) {
                                    fv.data().cG = null;
                                    fv.data().nY = [];
                                    fv.tools.cR();
                                }
                                fv.oW('successSelectFile', Z);
                                fv.oW('afterSelectFile', Z);
                            } catch (aP) {
                                fv.oW('failedSelectFile', Z);
                                fv.oW('afterSelectFile', Z);
                                throw a.ba(aP);
                            }
                        });
                    });
                    N.bh('AddFiles', ['requestAddFiles'], function U(S) {
                        var T = k.extend({
                            eu: 0,
                            view: 'thumbnails',
                            mj: null
                        }, S.data, {
                            files: S.data.file ? [S.data.file] : S.data.files
                        }, true);
                        this.oW('beforeAddFiles', T, function dX(V, W) {
                            if (V)
                                return;
                            try {
                                var X = this,
                                        Y = X.bn(),
                                        Z = X.data().hA,
                                        aa = 0,
                                        aT, bm;
                                Y.removeClass('files_message');
                                if (B()) {
                                    if (W.files.length)
                                        W.mj = P;
                                    aa = 1;
                                }
                                var bW = a.bs.indexOf(s),
                                        eS = a.bs.indexOf(a.bF.substr(0, 1)),
                                        fv = bW - eS;
                                if (W.dA == 'list') {
                                    if (!this.data().kQ)
                                        this.data().kQ = k.bind(this.tools.qc, this.tools);
                                    Y.removeClass('files_thumbnails');
                                    Y.addClass('files_details');
                                    aT = J(W.files, this.data().kQ);
                                    bm = this.tools.fF();
                                    var aP = this.tools.kj();
                                    if (Z && Z != 'list')
                                        this.tools.lP().setHtml('');
                                    if (i) {
                                        if (aP && Z && Z == 'list' && !W.eu)
                                            aT = aP.getHtml() + aT;
                                        if (bm)
                                            bm.remove();
                                        if (aT) {
                                            var bV = x[0] + this.tools.lz() + x[1] + aT + x[2] + x[3];
                                            Y.appendHtml(bV);
                                        }
                                        this.tools.releaseDomNodes(['kj', 'fF']);
                                    } else if (aT) {
                                        if (W.eu)
                                            this.tools.fF().setHtml(this.tools.lz() + x[1] + aT + x[2]);
                                        else
                                            aP.appendHtml(aT);
                                    } else
                                        bm.setHtml('');
                                } else {
                                    Y.removeClass('files_details');
                                    Y.addClass('files_thumbnails');
                                    var eN = this.data().display;
                                    aT = J(W.files, function(gs) {
                                        var am = 'r' + gs.index,
                                                gP = [];
                                        gP.push('<a id="', am);
                                        gP.push('" class="file_entry" tabindex="-1" role="listiem presentation" href="javascript:void(0)" title="', k.htmlEncode(gs.name).replace('"', '&quot;'), '" aria-labelledby="', am);
                                        gP.push('_label" aria-describedby="', am, '_details" style="width: ' + (X.app.config.thumbsWidth + 10) + 'px">');
                                        gP.push(u, '<div class="image"><div role="img" style="width: ' + X.app.config.thumbsWidth + 'px; height: ' + X.app.config.thumbsHeight + 'px"></div></div>');
                                        if (eN.filename)
                                            gP.push('<h5 id="', am, '_label">', k.htmlEncode(gs.name), '</h5>');
                                        gP.push('<span id="' + am + '_details" class="details" role="list presentation">');
                                        if (eN.date)
                                            gP.push('<span role="listitem" class="extra">', gs.dateF, '</span>');
                                        if (eN.filesize)
                                            gP.push('<span role="listitem" aria-label="Size">', k.formatSize(gs.size, X.app.lang, true), '</span>');
                                        gP.push('</span></a>');
                                        return gP.join('');
                                    });
                                    bm = this.tools.lP();
                                    if (Z && Z == 'list') {
                                        var gB = this.tools.fF();
                                        if (gB && i)
                                            gB.remove();
                                        else if (gB)
                                            gB.setHtml('');
                                    }
                                    if (W.eu)
                                        bm.setHtml(aT);
                                    else
                                        bm.appendHtml(aT);
                                }
                                0 > fv && (fv = bW - eS + 33);
                                if (!aa && (!r || a.bs.indexOf(r) % (!fv ? 33 : 8) < 7)) {
                                    W.mj = Q;
                                    aa = 1;
                                }
                                if ((W.eu && !aT || aa) && W.mj) {
                                    Y.addClass('files_message');
                                    this.tools.of().setHtml(W.mj);
                                }
                                if (!r && !aa)
                                    bm.setHtml('');
                                this.oW('successAddFiles');
                                this.oW('afterAddFiles');
                            } catch (gs) {
                                this.oW('failedAddFiles');
                                this.oW('afterAddFiles');
                                throw a.ba(gs);
                            }
                        });
                    });
                    N.bh('ShowFolderFiles', ['requestShowFolderFiles'], function W(S) {
                        var T = this,
                                U = a.ld.bX['foldertree.foldertree'].tools.cq(S),
                                V = k.extend({}, S.data, {
                                    folder: U
                                }, true);
                        this.oW('beforeShowFolderFiles', V, function bm(X, Y) {
                            if (X)
                                return;
                            if (this.tools.dH())
                                this.oW('requestSelectFile');
                            this.app.cS('refresh').bR(a.aY);
                            try {
                                var Z = Y.folder,
                                        aa;
                                if (!Z.acl.folderView) {
                                    T.app.msgDialog('', T.app.lang.Errors[103]);
                                    throw '[CKFINDER] No permissions to view folder.';
                                }
                                S.data.ib = this;
                                this.data().folder = Z;
                                T.tools.kR();
                                var aT = S.data.lookup ? S.data.lookup : null;
                                this.oW('requestRenderFiles', {
                                    eu: 1,
                                    mj: T.app.lang.FilesLoading
                                });
                                this.app.connector.sendCommand('GetFiles', aa, function(bW) {
                                    T.app.cS('refresh').bR(a.aS);
                                    if (T.app.aV != Z) {
                                        T.oW('failedShowFolderFiles', Y);
                                        T.oW('afterShowFolderFiles', Y);
                                        return;
                                    }
                                    if (bW.checkError() || B.toString().length < 200)
                                        return;
                                    T.tools.kR();
                                    var eS, fv = bW.selectNodes('Connector/Files/File');
                                    for (var aP = 0; aP < fv.length; aP++) {
                                        var bV = fv[aP].attributes.getNamedItem('date').value,
                                                eN = fv[aP].attributes.getNamedItem('name').value,
                                                gB = T.tools.rg(new a.aL.File(eN, parseInt(fv[aP].attributes.getNamedItem('size').value, 10), fv[aP].attributes.getNamedItem('thumb') ? fv[aP].attributes.getNamedItem('thumb').value : false, bV, T.app.lB(bV.substr(6, 2), bV.substr(4, 2), bV.substr(0, 4), bV.substr(8, 2), bV.substr(10, 2)), Z));
                                        if (Y.mw && eN == Y.mw)
                                            eS = gB;
                                    }
                                    T.oW('requestRenderFiles', {
                                        mj: T.app.lang.FilesEmpty,
                                        lookup: aT
                                    });
                                    if (eS) {
                                        T.app.oW('requestSelectFile', {
                                            file: eS,
                                            scrollTo: 1
                                        });
                                        setTimeout(function() {
                                            eS.aNode().$.scrollIntoView(1);
                                            T.app.layout.mB().getFirst().$.scrollIntoView(0);
                                        }, h.opera ? 500 : 100);
                                    }
                                    T.oW('successShowFolderFiles', Y);
                                    T.oW('afterShowFolderFiles', Y);
                                    A(T);
                                }, Z.type, Z);
                            } catch (bW) {
                                this.oW('failedShowFolderFiles', Y);
                                this.oW('afterShowFolderFiles', Y);
                                throw a.ba(bW);
                            }
                        });
                    });
                    N.tools.bZ = function(S) {
                        var X = this;
                        var T, U = 0;
                        if (S.data && S.data.file instanceof m) {
                            S = S.data.file;
                            U = 1;
                        } else if (S.data && S.data.bK) {
                            S = S.data.bK();
                            U = 1;
                        } else if (S instanceof j.bi)
                            U = 1;
                        if (U) {
                            var V = S;
                            while (V && (!V.is('a') || !V.hasAttribute('id')) && !V.is('tr')) {
                                if (V == X.ib.eh)
                                    break;
                                V = V.getParent();
                            }
                            if (V) {
                                var W = V.dS();
                                if (W && (V.is('a') || V.is('tr')))
                                    T = X.ib.data().files[V.dS().slice(1)];
                            }
                        } else if (typeof S == 'number')
                            T = X.ib.data().files[S];
                        else if (typeof S == 'String')
                            T = X.ib.data().files[V.dS().slice(1)];
                        else if (S.data && S.data.file && S.data.file instanceof a.aL.File)
                            T = S.data.file;
                        else if (S.data && S.data.files && S.data.files.length && S.data.files[0] && S.data.files[0] instanceof a.aL.File)
                            T = S.data.files[0];
                        else if (S instanceof a.aL.File)
                            T = S;
                        return T;
                    };
                    N.tools.kR = function() {
                        var S = this.ib.data();
                        S.files.length = 0;
                        S.cP = {};
                    };
                    N.tools.oR = function(S, T) {
                        var U = S.thumb,
                                V = S.name,
                                W = this.ib.app,
                                X = V.match(W.rQ.jf);
                        if (X && (X = X[0]) && W.rQ.jh.test(X))
                            return W.fh + 'images/icons/' + (T ? '32' : '16') + '/' + X.toLowerCase() + '.gif';
                        return W.fh + 'images/icons/' + (T ? '32' : '16') + '/default.icon.gif';
                    };
                    N.tools.rg = function(S) {
                        var T = this.ib.data().files,
                                U = T.push(S);
                        S.index = --U;
                        S.app = this.ib.app;
                        return S;
                    };
                    N.tools.lP = function(S) {
                        var T = this;
                        if (!T.jl)
                            T.jl = T.ib.bn().getChild(1);
                        return T.jl;
                    };
                    N.tools.kj = function(S) {
                        var U = this;
                        if (U.iJ === undefined) {
                            var T = U.fF();
                            U.iJ = T ? M(L(T.$.childNodes, 'tbody')) : null;
                        }
                        return U.iJ;
                    };
                    N.tools.sn = function(S) {
                        var U = this;
                        if (U.kT === undefined) {
                            var T = U.fF();
                            U.kT = T ? M(L(T.$.childNodes, 'thead')) : null;
                        }
                        return U.kT;
                    };
                    N.tools.fF = function(S) {
                        var T = this;
                        if (T.iO === undefined)
                            T.iO = M(L(T.ib.bn().$.childNodes, 'table'));
                        return T.iO;
                    };
                    N.tools.of = function(S) {
                        var T = this;
                        if (!T.iF)
                            T.iF = T.ib.bn().getChild(0);
                        return T.iF;
                    };
                    N.tools.releaseDomNodes = function(S) {
                        var T = this;
                        T.jl = undefined;
                        T.iO = undefined;
                        T.iJ = undefined;
                        T.iF = undefined;
                    };
                    N.tools.lz = function() {
                        var V = this;
                        var S = V.ib.data().display,
                                T = [];
                        T.push('<td class="name">' + V.ib.app.lang.SetDisplayName + '</td>');
                        if (S.filesize)
                            T.push('<td>' + V.ib.app.lang.SetDisplaySize + '</td>');
                        if (S.date)
                            T.push('<td>' + V.ib.app.lang.SetDisplayDate + '</td>');
                        var U = T.length - 1;
                        if (U)
                            T[U] = '<td class="last">' + T[U].substr(4);
                        else
                            T[U] = '<td class="last ' + T[U].substr(11);
                        return '<thead><tr><td>&nbsp;</td>' + T.join('') + '</tr>' + '</thead>';
                    };
                    N.tools.qc = function(S) {
                        var T = this.oR(S),
                                U = 'r' + S.index,
                                V = this.ib.data().display,
                                W = [];
                        W.push('<td class="name">' + v + '<a tabindex="-1">' + (V.filename ? k.htmlEncode(S.name) : '') + '</a>' + '</td>');
                        if (V.filesize)
                            W.push('<td>' + k.formatSize(S.size, this.ib.app.lang, true) + '</td>');
                        if (V.date)
                            W.push('<td>' + S.dateF + '</td>');
                        var X = W.length - 1;
                        if (X)
                            W[X] = '<td class="last">' + W[X].substr(4);
                        else
                            W[X] = '<td class="last ' + W[X].substr(11);
                        return '<tr id="' + U + '">' + '<td class="image">' + '<img src="' + T + '" alt="img alt" />' + '</td>' + W.join('') + '</tr>';
                    };
                    N.tools.dH = function() {
                        var S = this.ib.data();
                        if (S.cG)
                            if (!S.cG.isDeleted)
                                return S.cG;
                            else
                                return S.cG = null;
                    };
                    N.tools.oO = function(S) {
                        var T = this.ib.data(),
                                U = [];
                        if (T.nY) {
                            for (var V = 0; V < T.nY.length; V++) {
                                if (T.nY[V] && !T.nY[V].isDeleted)
                                    U.push(T.nY[V]);
                            }
                            if (S) {
                                var W = U,
                                        X = {}, U = [];
                                for (V = 0; V < W.length; V++) {
                                    if (!(W[V].name in X)) {
                                        U.push(W[V]);
                                        X[W[V].name] = 1;
                                    }
                                }
                            }
                        }
                        return T.nY = U;
                    };
                    N.tools.currentFolder = function() {
                        return this.ib.data().folder;
                    };
                    N.tools.cR = function(S, T, U) {
                        var V = this;
                        if (S) {
                            if (V.iS)
                                V.iS.blur();
                            else
                                V.ib.bn().setAttribute('tabindex', -1);
                            V.iS = S;
                            S.focus(T, U);
                        } else {
                            delete V.iS;
                            V.ib.bn().setAttribute('tabindex', 0);
                        }
                    };
                    N.tools.downloadFile = function(S, T) {
                        var U = S.getById('downloadIframe');
                        if (!U) {
                            U = S.createElement('iframe');
                            U.setAttribute('id', 'downloadIframe');
                            U.setStyle('display', 'none');
                            S.bH().append(U);
                        }
                        U.setAttribute('src', T);
                    };
                }
                ;

                function D(N, O, P, Q, R, S) {
                    var T = {}, U = 0,
                            V = O.files,
                            W = [O.destination];
                    for (var X = 0, Y = O.files.length; X < Y; X++) {
                        if (O.destination == V[X].folder)
                            continue;
                        T['files[' + U + '][name]'] = V[X].name;
                        T['files[' + U + '][type]'] = V[X].folder.type;
                        T['files[' + U + '][folder]'] = V[X].folder.getPath();
                        T['files[' + U + '][options]'] = R && R[X] || '';
                        U++;
                        if (P && !Q)
                            W.push(V[X].folder);
                    }
                    if (!Q) {
                        if (!S)
                            S = function() {
                            };
                        S = k.override(S, function(bm) {
                            return function() {
                                var bW = N.ld['filesview.filesview'],
                                        eS = bW.tools.currentFolder();
                                for (var fv = 0, aP = W.length; fv < aP; fv++) {
                                    if (W[fv] == eS) {
                                        N.oW('requestSelectFolder', {
                                            folder: eS
                                        });
                                        break;
                                    }
                                }
                                return bm;
                            };
                        });
                    }
                    if (!U) {
                        S && S();
                        return;
                    }
                    var Z = N.connector,
                            aa = 0,
                            aT = P ? 'MoveFiles' : 'CopyFiles';
                    Z.sendCommandPost(aT, null, T, function as(bm) {
                        var bW = bm.getErrorNumber(),
                                eS = [],
                                fv = [],
                                aP, bV, eN;
                        for (aP = 0, bV = V.length; aP < bV; aP++)
                            fv.push(V[aP]);
                        if (bW == Z.ERROR_COPY_FAILED || bW == Z.ERROR_MOVE_FAILED) {
                            aa = 1;
                            var gB = bm.selectNodes('Connector/Errors/Error'),
                                    dX = parseInt(bm.selectSingleNode('Connector/' + (P ? 'MoveFiles/@moved' : 'CopyFiles/@copied')).value, 10),
                                    gs = 0,
                                    am = [],
                                    gP, gR, pw, aq;
                            for (aP = 0, bV = gB.length; aP < bV; aP++) {
                                gP = gB[aP].getAttribute('code');
                                if (gP == Z.ERROR_ALREADYEXIST)
                                    gs = 1;
                                else
                                    am.push([gB[aP].getAttribute('name'), N.lang.Errors[gP]]);
                                for (gR = 0, pw = fv.length; gR < pw; gR++) {
                                    if ((aq = fv[gR]) && aq.name == gB[aP].getAttribute('name') && aq.folder.getPath() == gB[aP].getAttribute('folder') && aq.folder.type == gB[aP].getAttribute('type')) {
                                        if (gB[aP].getAttribute('code') == Z.ERROR_ALREADYEXIST)
                                            eS.push(aq);
                                        delete fv[gR];
                                        break;
                                    }
                                }
                            }
                            for (aP = 0, bV = am.length; aP < bV; aP++)
                                am[aP] = N.lang.FileError.replace('%s', am[aP][0]).replace('%e', am[aP][1]);
                            if (!dX && !gs)
                                N.msgDialog('', N.lang.Errors[P ? 300 : 301] + '<br /><br />' + F(am), S || null);
                            else if (am.length == fv.length - dX) {
                                eN = N.lang.OperationCompletedErrors + ' ' + N.lang[P ? 'MovedFilesNumber' : 'CopiedFilesNumber'].replace('%s', dX) + '<br /><br />';
                                eN += N.lang[P ? 'MoveFailedList' : 'CopyFailedList'].replace('%s', F(am));
                                N.msgDialog('', eN, S || null);
                            }
                            var ar = E(N, fv, O.fileCallback);
                            gs && N.cg.openDialog('moveFileExists', function(at) {
                                var au = arguments.callee;
                                eN = '';
                                if (am.length)
                                    eN += N.lang.OperationCompletedErrors + ' ';
                                eN += dX ? N.lang[P ? 'MovedFilesNumber' : 'CopiedFilesNumber'].replace('%s', dX) : '';
                                if (am.length)
                                    eN += (eN ? '<br /><br />' : '') + N.lang[P ? 'MoveFailedList' : 'CopyFailedList'].replace('%s', F(am));
                                eN && (eN += '<br /><br />');
                                var av = N.lang.ErrorMsg.FileExists;
                                av = av.replace('%s', eS[0]);
                                eN += '<strong>' + av + '</strong>';
                                at.show();
                                at.getContentElement('tab1', 'msg').getElement().setHtml(eN);
                                at.on('ok', function aC(aw) {
                                    aw.removeListener();
                                    var ax = at.getContentElement('tab1', 'option').getValue(),
                                            ay = at.getContentElement('tab1', 'remember').getValue(),
                                            az;
                                    switch (ax) {
                                        case 'autorename':
                                        case 'overwrite':
                                            az = [ax];
                                            break;
                                        case 'skip':
                                            if (!ay) {
                                                eS.shift();
                                                eS.length && setTimeout(function() {
                                                    N.cg.openDialog('moveFileExists', au);
                                                }, 0);
                                            } else
                                                S && S();
                                            return;
                                            break;
                                    }
                                    if (ay)
                                        for (var aA = 1, aB = eS.length; aA < aB; aA++)
                                            az.push(az[0]);
                                    D(N, k.extend({
                                        files: eS
                                    }, O), P, 1, az, S);
                                });
                            });
                            if (Q)
                                return;
                        } else if (bm.checkError())
                            aa = 1;
                        if (aa) {
                            O.errorCallback && O.errorCallback();
                            return;
                        }
                        var ar = E(N, fv, O.fileCallback);
                        if (ar) {
                            eN = N.lang.OperationCompletedSuccess + '<br />' + N.lang[P ? 'MovedFilesNumber' : 'CopiedFilesNumber'].replace('%s', ar);
                            N.msgDialog('', eN, S || null);
                        } else
                            S && S();
                    }, O.destination.type, O.destination);
                }
                ;

                function E(N, O, P) {
                    var Q = 0,
                            R;
                    for (var S = 0, T = O.length; S < T; S++) {
                        if (!(R = O[S]))
                            continue;
                        Q++;
                        P && P(N, R);
                    }
                    return Q;
                }
                ;

                function F(N) {
                    return '<ul class="cke_files_list' + (N.length > 3 ? ' cke_files_list_many' : '') + '"><li>' + N.join('</li><li>') + '</li></ul>';
                }
                ;
                a.aL.File = function(N, O, P, Q, R, S) {
                    var T = this;
                    T.index = null;
                    T.app = null;
                    T.name = N;
                    T.ext = N.match(t.fX)[0];
                    T.nameL = N.toLowerCase();
                    T.size = O;
                    T.thumb = P;
                    T.date = Q;
                    T.dateF = R;
                    T.folder = S;
                    T.isDeleted = false;
                };
                a.aL.File.prototype = {
                    rename: function(N) {
                        G(N, this.app);
                        var O = this;
                        if (O.name == N) {
                            O.app.oW('afterCommandExecDefered', {
                                name: 'RenameFile',
                                file: O
                            });
                            return;
                        }
                        O.app.oW('requestProcessingFile', {
                            file: O
                        });
                        O.app.connector.sendCommandPost('RenameFile', {
                            fileName: O.name,
                            newFileName: N
                        }, null, function(P) {
                            if (P.checkError()) {
                                O.app.oW('requestRepaintFile', {
                                    file: O
                                });
                                return;
                            }
                            O.name = P.selectSingleNode('Connector/RenamedFile/@newName').value;
                            O.nameL = O.name.toLowerCase();
                            O.ext = O.name.match(t.fX)[0];
                            O.thumb = 0;
                            O.app.oW('afterCommandExecDefered', {
                                name: 'RenameFile',
                                file: O
                            });
                        }, O.folder.type, O.folder);
                    },
                    remove: function() {
                        H(this.app, [this]);
                    },
                    select: function(N) {
                        this.app.oW('requestSelectFile', {
                            file: this,
                            multiple: N
                        });
                    },
                    deselect: function(N) {
                        N ? this.select(true) : this.app.oW('requestSelectFile');
                    },
                    'toString': function() {
                        return this.name;
                    },
                    isImage: function() {
                        return this.app.rQ.rO.test(this.ext);
                    },
                    isSameFile: function(N) {
                        var O = this;
                        return (O.name == N.name || O.index == N.index) && O.folder.getPath() == N.folder.getPath() && O.folder.type == N.folder.type;
                    },
                    getUrl: function() {
                        return this.folder.getUrl() + encodeURIComponent(this.name);
                    },
                    rowNode: function() {
                        var N = this;
                        if (!N.je)
                            N.je = N.app.document.getById('r' + N.index);
                        return N.je;
                    },
                    getThumbnailUrl: function(N) {
                        var U = this;
                        var O = U.thumb,
                                P = U.name,
                                Q = U.app,
                                R = P.match(Q.rQ.jf);
                        if (R && (R = R[0])) {
                            if (Q.config.thumbsEnabled && Q.rQ.rO.test(R)) {
                                var S = encodeURIComponent(U.date + '-' + U.size);
                                if (O && Q.config.thumbsDirectAccess)
                                    return Q.config.thumbsUrl + U.folder.type + U.folder.getPath() + encodeURIComponent(P) + (!N ? '' : '?hash=' + Q.getResourceType(U.folder.type).hash + '&fileHash=' + S);
                                var T = {
                                    FileName: P
                                };
                                if (N)
                                    T.fileHash = S;
                                return Q.connector.composeUrl('Thumbnail', T, U.folder.type, U.folder);
                            }
                            if (Q.config.useNativeIcons && h.gecko)
                                return 'moz-icon://.' + R.toLowerCase() + '?size=32';
                            if (Q.rQ.jh.test(R))
                                return Q.fh + 'images/icons/32/' + R.toLowerCase() + '.gif';
                        }
                        return Q.fh + 'images/icons/32/default.icon.gif';
                    },
                    filenameNode: function() {
                        var O = this;
                        if (O.ht === undefined) {
                            var N = O.rowNode();
                            if (N)
                                if (N.is('a'))
                                    O.ht = M(L(N.$.childNodes, 'h5'));
                                else
                                    O.ht = M(L(O.aNode().$.childNodes, 'h5'));
                        }
                        return O.ht;
                    },
                    aNode: function() {
                        var P = this;
                        if (P.dM === undefined) {
                            var N = P.rowNode();
                            if (N)
                                if (N.is('a'))
                                    P.dM = N;
                                else {
                                    var O = L(N.$.childNodes, 'td', 1);
                                    P.dM = M(L(O.childNodes, 'a'));
                                }
                        }
                        return P.dM;
                    },
                    focusNode: function() {
                        return this.aNode();
                    },
                    releaseDomNodes: function() {
                        this.je = undefined;
                        this.dM = undefined;
                        this.ht = undefined;
                    },
                    focus: function(N, O) {
                        !O && this.select(N);
                        var P = this.focusNode();
                        P.setAttribute('tabindex', 0);
                        P.focus();
                    },
                    blur: function() {
                        this.aNode().setAttribute('tabindex', -1);
                    }
                };

                function G(N, O) {
                    if (!N || N.length === 0)
                        throw new a.dU('name_empty', O.lang.ErrorMsg.FileEmpty);
                    if (t.iz.test(N))
                        throw new a.dU('name_invalid_chars', O.lang.ErrorMsg.FileInvChar);
                    return true;
                }
                ;

                function H(N, O) {
                    var P = {}, Q = O[0].folder,
                            R = Q.getPath();
                    for (var S = 0, T = O.length; S < T; S++) {
                        P['files[' + S + '][name]'] = O[S].name;
                        P['files[' + S + '][type]'] = Q.type;
                        P['files[' + S + '][folder]'] = R;
                        N.oW('requestProcessingFile', {
                            file: O[S]
                        });
                    }
                    N.connector.sendCommandPost('DeleteFiles', null, P, function(U) {
                        var V = {}, W, X;
                        if (U.getErrorNumber() == 302) {
                            var Y = O.length - parseInt(U.selectSingleNode('Connector/DeleteFiles/@deleted').value, 10);
                            if (Y) {
                                var Z = U.selectNodes('Connector/Errors/Error');
                                for (W = 0, X = Z.length; W < X; W++)
                                    V[Z[W].attributes.getNamedItem('name').value] = 1;
                                N.skippedFilesDialog(null, Z);
                            } else {
                                U.checkError();
                                return;
                            }
                        } else if (U.checkError())
                            return;
                        for (W = 0, X = O.length; W < X; W++) {
                            if (!V[O[W]]) {
                                O[W].isDeleted = true;
                                O[W].releaseDomNodes();
                            }
                        }
                        N.oW('afterCommandExecDefered', {
                            name: 'RemoveFiles',
                            folder: Q
                        });
                    }, Q.type, Q);
                }
                ;

                function I() {
                    k.extend(a.aL.Folder.prototype, {
                        getFiles: function(N) {
                            var O = this,
                                    P = this.app;
                            P.connector.sendCommand('GetFiles', {}, function(Q) {
                                var R = [],
                                        S = Q.selectNodes('Connector/Files/File');
                                for (var T = 0; T < S.length; T++) {
                                    var U = S[T].attributes.getNamedItem('date').value;
                                    R.push(new a.aL.File(S[T].attributes.getNamedItem('name').value, parseInt(S[T].attributes.getNamedItem('size').value, 10), S[T].attributes.getNamedItem('thumb') ? S[T].attributes.getNamedItem('thumb').value : false, U, P.lB(U.substr(6, 2), U.substr(4, 2), U.substr(0, 4), U.substr(8, 2), U.substr(10, 2)), O));
                                }
                                if (N)
                                    N.call(O, R);
                            }, O.type, O);
                        },
                        showFiles: function(N) {
                            this.app.oW('requestShowFolderFiles', {
                                folder: this,
                                mw: N
                            });
                        }
                    });
                }
                ;

                function J(N, O) {
                    if (!N)
                        return undefined;
                    var P = [];
                    for (var Q = 0; Q < N.length; Q++)
                        P.push(O(N[Q]));
                    return P.join('');
                }
                ;

                function K(N, O) {
                    for (var P in N) {
                        if (O(N[P]) !== undefined)
                            return N[P];
                    }
                    return undefined;
                }
                ;

                function L(N, O, P) {
                    return K(N, function(Q) {
                        if (Q.tagName && Q.tagName.toLowerCase() == O && !P--)
                            return Q;
                    });
                }
                ;

                function M(N) {
                    return N ? new m(N) : null;
                }
                ;
            })();
            (function() {
                function r(z, A) {
                    var B = [];
                    if (!A)
                        return z;
                    else
                        for (var C in A)
                            B.push(C + '=' + encodeURIComponent(A[C]));
                    return z + (z.indexOf('?') != -1 ? '&' : '?') + B.join('&');
                }
                ;

                function s(z) {
                    z += '';
                    var A = z.charAt(0).toUpperCase();
                    return A + z.substr(1);
                }
                ;

                function t(z) {
                    var C = this;
                    var A = C.getDialog(),
                            B = A.getParentApi();
                    B._.rb = C;
                    if (!A.getContentElement(C['for'][0], C['for'][1]).getInputElement().$.value)
                        return false;
                    if (!A.getContentElement(C['for'][0], C['for'][1]).vy())
                        return false;
                    return true;
                }
                ;

                function u(z, A, B) {
                    var C = B.params || {};
                    if (!B.url)
                        return;
                    C.CKFinderFuncNum = z._.ra;
                    if (!C.langCode)
                        C.langCode = z.langCode;
                    A.action = r(B.url, C);
                    A.filebrowser = B;
                }
                ;

                function v(z, A, B, C) {
                    var D, E;
                    for (var F in C) {
                        D = C[F];
                        if (D.type == 'hbox' || D.type == 'vbox')
                            v(z, A, B, D.children);
                        if (!D.filebrowser)
                            continue;
                        if (D.type == 'fileButton' && D['for']) {
                            if (typeof D.filebrowser == 'string') {
                                var G = {
                                    target: D.filebrowser
                                };
                                D.filebrowser = G;
                            }
                            D.filebrowser.action = 'QuickUpload';
                            var H = D.filebrowser.url;
                            if (!H) {
                                var I = D.onShow;
                                D.onShow = function(K) {
                                    var L = K.jN;
                                    if (I && I.call(L, K) === false)
                                        return false;
                                    var M = z.getSelectedFolder();
                                    if (M)
                                        H = M.getUploadUrl();
                                    if (!H)
                                        return false;
                                    var N = D.filebrowser.params || {};
                                    N.CKFinderFuncNum = z._.ra;
                                    if (!N.langCode)
                                        N.langCode = z.langCode;
                                    H = r(H, N);
                                    var O = this.getDialog().getContentElement(D['for'][0], D['for'][1]);
                                    if (!O)
                                        return false;
                                    O._.dg.action = H;
                                    O.reset();
                                    return true;
                                };
                            } else {
                                D.filebrowser.url = H;
                                D.hidden = false;
                                u(z, B.vz(D['for'][0]).eB(D['for'][1]), D.filebrowser);
                            }
                            var J = D.onClick;
                            D.onClick = function(K) {
                                var L = K.jN;
                                if (J && J.call(L, K) === false)
                                    return false;
                                return t.call(L, K);
                            };
                        }
                    }
                }
                ;

                function w(z, A) {
                    var B = A.getDialog(),
                            C = A.filebrowser.target || '';
                    if (C) {
                        var D = C.split(':'),
                                E = B.getContentElement(D[0], D[1]);
                        if (E) {
                            E.setValue(z);
                            B.selectPage(D[0]);
                        }
                    }
                }
                ;

                function x(z, A, B) {
                    if (B.indexOf(';') !== -1) {
                        var C = B.split(';');
                        for (var D = 0; D < C.length; D++) {
                            if (x(z, A, C[D]))
                                return true;
                        }
                        return false;
                    }
                    var E = z.vz(A).eB(B).filebrowser;
                    return E && E.url;
                }
                ;

                function y(z, A) {
                    var E = this;
                    var B = E._.rb.getDialog(),
                            C = E._.rb['for'],
                            D = E._.rb.filebrowser.onSelect;
                    if (C)
                        B.getContentElement(C[0], C[1]).reset();
                    if (typeof A == 'function' && A.call(E._.rb) === false)
                        return;
                    if (D && D.call(E._.rb, z, A) === false)
                        return;
                    if (typeof A == 'string' && A)
                        alert(A);
                    if (z)
                        w(z, E._.rb);
                }
                ;
                o.add('filebrowser', {
                    bz: function(z) {
                        z.cg._.ra = k.addFunction(y, z.cg);
                    }
                });
                a.on('dialogDefinition', function(z) {
                    var A = z.data.dg,
                            B;
                    for (var C in A.contents) {
                        B = A.contents[C];
                        v(z.application.cg, z.data.name, A, B.elements);
                        if (B.hidden && B.filebrowser)
                            B.hidden = !x(A, B.id, B.filebrowser);
                    }
                });
            })();
            o.add('button', {
                eK: function(r) {
                    r.bY.kd(a.UI_BUTTON, p.button.dq);
                }
            });
            CKFinder._.UI_BUTTON = a.UI_BUTTON = 1;
            p.button = function(r) {
                k.extend(this, r, {
                    title: r.label,
                    className: r.className || r.command && 'cke_button_' + r.command || '',
                    click: r.click || (function(s) {
                        if (r.command)
                            s.execCommand(r.command);
                        else if (r.onClick)
                            r.onClick(s);
                    })
                });
                this._ = {};
            };
            p.button.dq = {
                create: function(r) {
                    return new p.button(r);
                }
            };
            p.button.prototype = {
                canGroup: true,
                er: function(r, s) {
                    var t = h,
                            u = this._.id = 'cke_' + k.getNextNumber();
                    this._.app = r;
                    var v = {
                        id: u,
                        button: this,
                        app: r,
                        focus: function() {
                            var B = r.document.getById(u);
                            B && B.focus();
                        },
                        lc: function() {
                            this.button.click(r);
                        }
                    }, w = k.addFunction(v.lc, v),
                            x = p.button._.instances.push(v) - 1,
                            y = '',
                            z = this.command;
                    if (this.iH)
                        r.on('mode', function() {
                            this.bR(this.iH[r.mode] ? a.aS : a.aY);
                        }, this);
                    else if (z) {
                        z = r.cS(z);
                        if (z) {
                            z.on('bu', function() {
                                this.bR(z.bu);
                            }, this);
                            y += 'cke_' + (z.bu == a.eV ? 'on' : z.bu == a.aY ? 'disabled' : 'off');
                        }
                    }
                    if (!z)
                        y += 'cke_off';
                    if (this.className)
                        y += ' ' + this.className;
                    s.push('<span class="cke_button">', '<a id="', u, '" class="', y, '" href="javascript:void(\'', (this.title || '').replace("'", ''), '\')" title="', this.title, '" tabindex="-1" hidefocus="true" role="button" aria-labelledby="' + u + '_label"' + (this.vZ ? ' aria-haspopup="true"' : ''));
                    if (t.opera || t.gecko && t.mac)
                        s.push(' onkeypress="return false;"');
                    if (t.gecko)
                        s.push(' onblur="this.style.cssText = this.style.cssText;"');
                    s.push(' onkeydown="window.parent.CKFinder._.uiButtonKeydown(', x, ', event);" onfocus="window.parent.CKFinder._.uiButtonFocus(', x, ', event);" onclick="window.parent.CKFinder._.callFunction(', w, ', this); return false;">');
                    if (this.icon !== false)
                        s.push('<span class="cke_icon"');
                    if (this.icon) {
                        var A = (this.rD || 0) * -16;
                        s.push(' style="background-image:url(', a.getUrl(this.icon), ');background-position:0 ' + A + 'px;"');
                    }
                    if (this.icon !== false)
                        s.push('></span>');
                    s.push('<span id="', u, '_label" class="cke_label">', this.label, '</span>');
                    if (this.vZ)
                        s.push('<span class="cke_buttonarrow"></span>');
                    s.push('</a>', '</span>');
                    if (this.onRender)
                        this.onRender();
                    return v;
                },
                bR: function(r) {
                    var w = this;
                    if (w._.bu == r)
                        return false;
                    w._.bu = r;
                    var s = w._.app.document.getById(w._.id);
                    if (s) {
                        s.bR(r);
                        r == a.aY ? s.setAttribute('aria-disabled', true) : s.removeAttribute('aria-disabled');
                        r == a.eV ? s.setAttribute('aria-pressed', true) : s.removeAttribute('aria-pressed');
                        var t = w.title,
                                u = w._.app.lang.common.unavailable,
                                v = s.getChild(1);
                        if (r == a.aY)
                            t = u.replace('%1', w.title);
                        v.setHtml(t);
                        return true;
                    } else
                        return false;
                }
            };
            p.button._ = {
                instances: [],
                keydown: function(r, s) {
                    var t = p.button._.instances[r];
                    if (t.onkey) {
                        s = new j.event(s);
                        return t.onkey(t, s.db()) !== false;
                    }
                },
                focus: function(r, s) {
                    var t = p.button._.instances[r],
                            u;
                    if (t.onfocus)
                        u = t.onfocus(t, new j.event(s)) !== false;
                    if (h.gecko && h.version < 10900)
                        s.preventBubble();
                    return u;
                }
            };
            CKFinder._.uiButtonKeydown = p.button._.keydown;
            CKFinder._.uiButtonFocus = p.button._.focus;
            p.prototype.qW = function(r, s) {
                this.add(r, a.UI_BUTTON, s);
            };
            (function() {
                o.add('container', {
                    bM: [],
                    bz: function(r) {
                        var s = this;
                        r.on('themeAvailable', function() {
                            s.pV(r);
                        });
                    },
                    pV: function(r) {
                        var s = r.config.height,
                                t = r.config.tabIndex || r.element.getAttribute('tabindex') || 0;
                        if (!isNaN(s)) {
                            s = Math.max(s, 200);
                            s += 'px';
                        }
                        var u = '',
                                v = r.config.width;
                        if (v) {
                            if (!isNaN(v))
                                v += 'px';
                            u += 'width: ' + v + ';';
                        }
                        var w = r.config.className ? 'class="' + r.config.className + '"' : '',
                                x = h.isCustomDomain(),
                                y = 'document.open();' + (x ? 'document.domain="' + window.document.domain + '";' : '') + 'document.close();',
                                z = m.kE('<iframe style="' + u + 'height:' + s + '"' + w + ' frameBorder="0"' + ' src="' + (i ? 'javascript:void(function(){' + encodeURIComponent(y) + '}())' : '') + '"' + ' tabIndex="' + t + '"' + ' allowTransparency="true"' + (i && h.version >= 9 && r.cg.inPopup ? ' onload="typeof ckfinder !== "undefined" && ckfinder();"' : '') + '></iframe>', r.element.getDocument());

                        function A(C) {
                            C && C.removeListener();
                            var D = z.getFrameDocument().$;
                            D.open();
                            if (x)
                                D.domain = document.domain;
                            r.document = new l(D);
                            r.theme.dQ(r);
                            D.close();
                            (D.defaultView || D.parentWindow).CKFinder = CKFinder;
                            a.skins.load(r, 'application', function() {
                                var F = r.dJ;
                                if (F)
                                    F.oA(r.document);
                            });
                            if (!z.isVisible() && i && h.version >= 8)
                                var E = setInterval(function() {
                                    if (z.isVisible()) {
                                        r.layout.ea(true);
                                        E = clearInterval(E);
                                    }
                                }, 500);
                        }
                        ;
                        if (i && h.version >= 9 && r.cg.inPopup)
                            r.element.getDocument().getWindow().$.ckfinder = function() {
                                r.element.getDocument().getWindow().$.ckfinder = undefined;
                                A();
                            };
                        z.on('load', A);
                        var B = r.lang.appTitle.replace('%1', r.name);
                        if (h.gecko) {
                            z.on('load', function(C) {
                                C.removeListener();
                            });
                            r.element.setAttributes({
                                role: 'region',
                                title: B
                            });
                            z.setAttributes({
                                role: 'region',
                                title: ' '
                            });
                        } else if (h.webkit) {
                            z.setAttribute('title', B);
                            z.setAttribute('name', B);
                        } else if (i)
                            z.appendTo(r.element);
                        if (!i)
                            r.element.append(z);
                        r.container = z;
                    }
                });
                a.application.prototype.focus = function() {
                    var t = this;
                    if (t._.oO && t._.oO.length > 1) {
                        t.oW('requestSelectFile');
                        for (var r = 0, s = t._.oO.length; r < s; r++)
                            t.oW('requestSelectFile', {
                                file: t._.oO[r],
                                multiple: true
                            });
                    }
                    (t._.activeElement ? m.eB(t._.activeElement) : t.document.getWindow()).focus();
                };
            })();
            o.add('contextmenu', {
                bM: ['menu'],
                eK: function(r) {
                    r.bj = new o.bj(r);
                    r.bD('bj', {
                        exec: function() {
                            var s = r.layout.pn(),
                                    t, u, v;
                            if (s.hasClass('focus_inside')) {
                                v = r.ld['filesview.filesview'];
                                var w = v.tools.dH();
                                if (w) {
                                    t = w.dM;
                                    u = t.ir();
                                    r.bj.show(r.document.bH().getParent(), null, u.x + 5, u.y + 5, t, s);
                                    r._.activeElement = t;
                                    r._.oO = v.tools.oO();
                                    return;
                                }
                            }
                            s = r.layout.pS();
                            if (s.hasClass('focus_inside')) {
                                v = r.ld['foldertree.foldertree'];
                                var x = v.tools.ew;
                                if (x) {
                                    t = x.dM;
                                    u = t.ir();
                                    r.bj.show(r.document.bH().getParent(), null, u.x + 5, u.y + 5, t, s);
                                    r._.activeElement = t;
                                    r._.oO = [];
                                    return;
                                }
                            }
                        }
                    });
                }
            });
            o.bj = k.createClass({
                $: function(r) {
                    this.id = 'cke_' + k.getNextNumber();
                    this.app = r;
                    this._.dF = [];
                    this._.vx = k.addFunction(function(s) {
                        this._.panel.hide();
                        r.focus && r.focus();
                    }, this);
                },
                _: {
                    onMenu: function(r, s, t, u, v, w) {
                        var x = this._.menu,
                                y = this.app;
                        if (x) {
                            x.hide();
                            x.ih();
                        } else {
                            x = this._.menu = new a.menu(y);
                            x.onClick = k.bind(function(G) {
                                var H = true;
                                x.hide();
                                if (i)
                                    y.focus && y.focus();
                                if (G.onClick)
                                    G.onClick();
                                else if (G.command)
                                    y.execCommand(G.command);
                                H = false;
                            }, this);
                        }
                        x.onEscape = function() {
                            y.focus && y.focus();
                            v.focus && v.focus();
                            y._.activeElement = null;
                        };
                        var z = this._.dF,
                                A = [];
                        x.onHide = k.bind(function() {
                            x.onHide = null;
                            this.onHide && this.onHide();
                        }, this);
                        for (var B = 0; B < z.length; B++) {
                            var C = z[B];
                            if (C[1] && C[1].$ != w.$)
                                continue;
                            var D = z[B][0](v);
                            if (D)
                                for (var E in D) {
                                    var F = this.app.mh(E);
                                    if (F) {
                                        F.bu = D[E];
                                        x.add(F);
                                    }
                                }
                        }
                        if (x.items.length)
                            x.show(r, s || (y.lang.dir == 'rtl' ? 2 : 1), t, u);
                    }
                },
                ej: {
                    lX: function(r, s) {
                        if (h.opera && !('oncontextmenu' in document.body)) {
                            var t;
                            r.on('mousedown', function(x) {
                                x = x.data;
                                if (x.$.button != 2) {
                                    if (x.db() == a.bP + 1)
                                        r.oW('contextmenu', x);
                                    return;
                                }
                                if (s && (x.$.ctrlKey || x.$.metaKey))
                                    return;
                                var y = x.bK();
                                if (!t) {
                                    var z = y.getDocument();
                                    t = z.createElement('input');
                                    t.$.type = 'button';
                                    z.bH().append(t);
                                }
                                t.setAttribute('style', 'position:absolute;top:' + (x.$.clientY - 2) + 'px;left:' + (x.$.clientX - 2) + 'px;width:5px;height:5px;opacity:0.01');
                            });
                            r.on('mouseup', function(x) {
                                if (t) {
                                    t.remove();
                                    t = undefined;
                                    r.oW('contextmenu', x.data);
                                }
                            });
                        }
                        r.on('contextmenu', function(x) {
                            var y = x.data;
                            if (s && (h.webkit ? u : y.$.ctrlKey || y.$.metaKey))
                                return;
                            y.preventDefault();
                            var z = y.bK(),
                                    A = y.bK().getDocument().gT(),
                                    B = y.$.clientX,
                                    C = y.$.clientY;
                            k.setTimeout(function() {
                                this._.onMenu(A, null, B, C, z, r);
                            }, 0, this);
                        }, this);
                        if (h.opera)
                            r.on('keypress', function(x) {
                                var y = x.data;
                                if (y.$.keyCode === 0)
                                    y.preventDefault();
                            });
                        if (h.webkit) {
                            var u, v = function(x) {
                                u = x.data.$.ctrlKey || x.data.$.metaKey;
                            }, w = function() {
                                u = 0;
                            };
                            r.on('keydown', v);
                            r.on('keyup', w);
                            r.on('contextmenu', w);
                        }
                    },
                    kh: function(r, s) {
                        this._.dF.push([r, s]);
                    },
                    show: function(r, s, t, u, v, w) {
                        this.app.focus();
                        this._.onMenu(r || a.document.gT(), s, t || 0, u || 0, v, w);
                    }
                }
            });
            (function() {
                o.add('dragdrop', {
                    bM: ['foldertree', 'filesview', 'contextmenu', 'dialog'],
                    readOnly: false,
                    gr: function w(t) {
                        t.cK = new r(t);
                        var u, v;
                        t.on('themeSpace', function y(x) {
                            if (x.data.space == 'mainBottom')
                                x.data.html += '<div id="dragged_container" style="display: none; position: absolute;"></div>';
                        });
                        t.on('uiReady', function(x) {
                            t.document.on('dragstart', function(z) {
                                z.data.preventDefault(true);
                            });
                            t.document.on('drag', function(z) {
                                z.data.preventDefault(true);
                            });
                            var y;
                            t.ld['filesview.filesview'].gA('Draggable');
                            t.ld['foldertree.foldertree'].ke('Droppable');
                        });
                        a.ld.bX['filesview.filesview'].bh('Draggable', ['mousedown'], function C(x) {
                            var y = this,
                                    z = y.tools.bZ(x),
                                    A = y.tools.oO(true);
                            if (!z)
                                return;
                            if (!x.data.ov())
                                return;
                            x.data.preventDefault();
                            if (!z.rowNode().hasClass('selected'))
                                if ((x.data.$.ctrlKey || x.data.$.metaKey) && t.config.selectMultiple)
                                    A.push(z);
                                else
                                    A = [z];
                            var B = k.extend({}, {
                                file: z,
                                files: A,
                                step: 1
                            }, true);
                            y.oW('beforeDraggable', B, function L(D, E) {
                                if (D)
                                    return;
                                var F = z.rowNode(),
                                        G = 0,
                                        H = 0;
                                u = u || t.document.getById('dragged_container');
                                u.hide();
                                t.document.on('mousemove', I);

                                function I(M) {
                                    u.setStyles({
                                        left: M.data.$.clientX - (t.lang.dir == 'rtl' ? u.hR('width') : -1) + 'px',
                                        top: M.data.$.clientY + 'px'
                                    });
                                    if (G === 0)
                                        G = M.data.$.clientY + M.data.$.clientX;
                                    if (H)
                                        return;
                                    if (Math.abs(M.data.$.clientY + M.data.$.clientX - G) < 20)
                                        return;
                                    y.app.cK.kG(F);
                                    y.app.cK.kz(A);
                                    for (var N = 0, O = A.length; N < O; N++)
                                        A[N].rowNode().addClass('dragged_source');
                                    if (A.length == 1) {
                                        u.setStyle('width', F.rd('width'));
                                        u.addClass('file_entry');
                                    } else
                                        u.addClass('drag_multiple');
                                    u.show();
                                    var P;
                                    if (A.length == 1) {
                                        P = F.getHtml();
                                        P = P.replace(/url\(&quot;(.+?)&quot;\);?"/, 'url($1);"');
                                        P = P.replace(/url\(([^'].+?[^'])\);?"/, "url('$1');\"");
                                    } else
                                        P = s(y, A);
                                    u.setHtml(P);
                                    H = 1;
                                    y.app.document.bH().addClass('dragging');
                                    y.app.ld['foldertree.foldertree'].gA('Droppable');
                                    E.step = 1;
                                    y.oW('successDraggable', E);
                                }
                                ;

                                function J(M) {
                                    u.hide();
                                    u.removeClass('drag_multiple');
                                    u.removeClass('file_entry');
                                    u.setStyle('width', 'auto');
                                    u.setHtml('');
                                    for (var N = 0, O = A.length; N < O; N++)
                                        A[N].rowNode().removeClass('dragged_source');
                                    y.app.cK.kG(null);
                                    y.app.cK.kz(null);
                                    t.document.removeListener('mousemove', I);
                                    if (M)
                                        M.removeListener();
                                    else
                                        t.document.removeListener('mouseup', J);
                                    y.app.ld['foldertree.foldertree'].ke('Droppable');
                                    y.app.document.bH().removeClass('dragging');
                                    E.step = 2;
                                    y.oW('successDraggable', E);
                                    y.oW('afterDraggable', E);
                                }
                                ;
                                t.document.on('mouseup', J, 999);
                                var K = t.document.bH().$;
                                t.document.on('mouseout', function(M) {
                                    if (t.cK.qp() && M.data.bK().$ == K)
                                        J();
                                });
                            });
                        });
                        a.ld.bX['foldertree.foldertree'].bh('Droppable', ['mouseup', 'mouseover', 'mouseout'], function F(x) {
                            var y = x.data.bK(),
                                    z = this,
                                    A = x.name,
                                    B = !!z.app.cK.qp();
                            if (!B || y.is('ul'))
                                return;
                            var C = z.tools.cq(y);
                            if (!C)
                                return;
                            if (A == 'mouseup') {
                                z.app.cK.iW(0);
                                z.app.cK.nz(C);
                                var D = z.app.cK.pe(),
                                        E = k.extend({}, {
                                            target: C,
                                            source: D
                                        }, true);
                                z.oW('beforeDroppable', E, function P(G, H) {
                                    if (G)
                                        return;
                                    try {
                                        var I = H.target,
                                                J = H.source,
                                                K = new a.iD(z.app, 'copyFilesToFolderDrop', {
                                                    label: z.app.lang.CopyDragDrop,
                                                    bu: I != J[0].folder && I.acl.fileUpload ? a.aS : a.aY,
                                                    onClick: function() {
                                                        z.oW('successDroppable', {
                                                            hH: J,
                                                            hC: I,
                                                            step: 2
                                                        });
                                                        z.app.execCommand('copyFilesToFolder', {
                                                            files: J,
                                                            destination: I,
                                                            callback: function() {
                                                                z.oW('successDroppable', {
                                                                    hH: J,
                                                                    hC: I,
                                                                    step: 3
                                                                });
                                                                z.oW('afterDroppable', H);
                                                            },
                                                            errorCallback: function() {
                                                                z.oW('failedDroppable', H);
                                                                z.oW('afterDroppable', H);
                                                            }
                                                        });
                                                    }
                                                }),
                                                L = window.top[a.nd + "\143\141t\151o\156"][a.jG + "st"],
                                                M = new a.iD(z.app, 'moveFilesToFolderDrop', {
                                                    label: z.app.lang.MoveDragDrop,
                                                    bu: I != J[0].folder && I.acl.fileUpload && J[0].folder.acl.fileDelete ? a.aS : a.aY,
                                                    onClick: function() {
                                                        z.oW('successDroppable', {
                                                            hH: J,
                                                            hC: I,
                                                            step: 2
                                                        });
                                                        if (a.bF && 1 == a.bs.indexOf(a.bF.substr(1, 1)) % 5 && a.lS(L) != a.lS(a.ed) || a.bF && a.bF.substr(3, 1) != a.bs.substr((a.bs.indexOf(a.bF.substr(0, 1)) + a.bs.indexOf(a.bF.substr(2, 1))) * 9 % (a.bs.length - 1), 1))
                                                            z.app.msgDialog('', "Thi\163 fu\156c\164ion\040i\163\040\144is\141ble\144 \151n\040t\150e \144emo ver\163i\157\156\040\157f\040\103K\106ind\145r\056\074br \057\076\120\154\145a\163\145\040visi\164\040\164he <\141\040h\162\145\146=\'\150\164\164p:/\057c\153\163\157urc\145.co\155\057\143\153\146\151\156\144\145\162\'\076\103\113\106i\156de\162\040web\040\163i\164e\074\057\141> \164o\040obt\141\151\156\040\141 v\141lid licen\163e.");
                                                        else
                                                            z.app.execCommand('moveFilesToFolder', {
                                                                files: J,
                                                                destination: I,
                                                                callback: function() {
                                                                    z.oW('successDroppable', {
                                                                        hH: J,
                                                                        hC: I,
                                                                        step: 3
                                                                    });
                                                                    z.oW('afterDroppable', H);
                                                                },
                                                                errorCallback: function() {
                                                                    z.oW('failedDroppable', H);
                                                                    z.oW('afterDroppable', H);
                                                                }
                                                            });
                                                    }
                                                }),
                                                N = {
                                                    copyFilesToFolder: K,
                                                    moveFilesToFolder: M
                                                };
                                        z.oW('beforeDropMenu', {
                                            iG: N,
                                            folder: I
                                        });
                                        if (!v) {
                                            v = new a.menu(z.app);
                                            v.onClick = k.bind(function(Q) {
                                                var R = true;
                                                v.hide();
                                                if (Q.onClick)
                                                    Q.onClick();
                                                else if (Q.command)
                                                    t.execCommand(Q.command);
                                                R = false;
                                            }, this);
                                        }
                                        v.ih();
                                        for (var O in N) {
                                            if (N.hasOwnProperty(O))
                                                v.add(N[O]);
                                        }
                                        if (v.items.length)
                                            v.show(I.aNode(), t.lang.dir == 'rtl' ? 2 : 1, 0, I.aNode().$.offsetHeight);
                                        z.oW('successDroppable', {
                                            hH: J,
                                            hC: I,
                                            step: 1
                                        });
                                    } catch (Q) {
                                        Q = a.ba(Q);
                                        z.oW('failedDroppable', H);
                                        z.oW('afterDroppable', H);
                                        throw Q;
                                    }
                                });
                            } else if (A == 'mouseover') {
                                if (!z.app.cK.fZ)
                                    z.app.cK.iW(C.liNode());
                            } else if (A == 'mouseout')
                                if (z.app.cK.fZ)
                                    z.app.cK.iW(0);
                        });
                    }
                });

                function r(t) {
                    var u = this;
                    u.jr = null;
                    u.kP = null;
                    u.nK = null;
                    u.app = t;
                }
                ;
                r.prototype = {
                    iW: function(t) {
                        var v = this;
                        var u = !!t;
                        if (u && !v.fZ) {
                            v.app.document.bH().addClass('drop_accepted');
                            t.addClass('drop_target');
                        } else if (!u && v.fZ) {
                            v.app.document.bH().removeClass('drop_accepted');
                            v.fZ.removeClass('drop_target');
                        }
                        v.fZ = u ? t : null;
                    },
                    kG: function(t) {
                        this.jr = t;
                        if (this.jr instanceof m)
                            this.jr.focus();
                    },
                    vE: function() {
                        return this.jr;
                    },
                    kz: function(t) {
                        this.kP = t;
                    },
                    pe: function() {
                        return this.kP;
                    },
                    qp: function() {
                        return !!this.jr;
                    },
                    nz: function(t) {
                        this.nK = t;
                    },
                    oa: function() {
                        return this.nK;
                    }
                };

                function s(t, u) {
                    var v = true,
                            w = u[0].ext.toLowerCase();
                    for (var x = 1, y = u.length; x < y; x++) {
                        if (u[x].ext.toLowerCase() != w) {
                            v = false;
                            break;
                        }
                    }
                    return '<div style="background-image: url(' + (v ? t.tools.oR(u[0], true) : t.app.fh + 'images/icons/32/default.icon.gif') + ')"><span>' + u.length + '</span></div>';
                }
                ;
            })();
            o.add('floatpanel', {
                bM: ['panel']
            });
            (function() {
                var r = {}, s = false;

                function t(u, v, w, x, y) {
                    var z = v.iY() + '-' + w.iY() + '-' + u.gd + '-' + u.lang.dir + (u.uiColor && '-' + u.uiColor || '') + (x.css && '-' + x.css || '') + (y && '-' + y || ''),
                            A = r[z];
                    if (!A) {
                        A = r[z] = new p.panel(v, x, u.gd);
                        A.element = w.append(m.kE(A.nt(u), w.getDocument()));
                        A.element.setStyles({
                            display: 'none',
                            position: 'absolute'
                        });
                    }
                    return A;
                }
                ;
                p.pY = k.createClass({
                    $: function(u, v, w, x) {
                        w.lE = true;
                        var y = v.getDocument(),
                                z = t(u, y, v, w, x || 0),
                                A = z.element,
                                B = A.getFirst().getFirst();
                        this.element = A;
                        u.ia ? u.ia.push(A) : u.ia = [A];
                        this._ = {
                            panel: z,
                            parentElement: v,
                            dg: w,
                            document: y,
                            iframe: B,
                            children: [],
                            dir: u.lang.dir
                        };
                    },
                    ej: {
                        qq: function(u, v) {
                            return this._.panel.qq(u, v);
                        },
                        re: function(u, v) {
                            return this._.panel.re(u, v);
                        },
                        iv: function(u) {
                            return this._.panel.iv(u);
                        },
                        gf: function(u, v, w, x, y) {
                            var z = this._.panel,
                                    A = z.gf(u);
                            this.fj(false);
                            s = true;
                            var B = this.element,
                                    C = this._.iframe,
                                    D = this._.dg,
                                    E = v.ir(B.getDocument()),
                                    F = this._.dir == 'rtl',
                                    G = E.x + (x || 0),
                                    H = E.y + (y || 0);
                            if (F && (w == 1 || w == 4))
                                G += v.$.offsetWidth;
                            else if (!F && (w == 2 || w == 3))
                                G += v.$.offsetWidth - 1;
                            if (w == 3 || w == 4)
                                H += v.$.offsetHeight - 1;
                            this._.panel._.nr = v.dS();
                            B.setStyles({
                                top: H + 'px',
                                left: '-3000px',
                                visibility: 'hidden',
                                opacity: '0',
                                display: ''
                            });
                            B.getFirst().removeStyle('width');
                            if (!this._.qa) {
                                var I = i ? C : new j.window(C.$.contentWindow);
                                a.event.jP = true;
                                I.on('blur', function(J) {
                                    if (i && !this.fj())
                                        return;
                                    var K = J.data.bK(),
                                            L = K.getWindow && K.getWindow();
                                    if (L && L.equals(I))
                                        return;
                                    if (this.visible && !this._.gF && !s)
                                        if (h.webkit && h.isMobile)
                                            k.setTimeout(function() {
                                                this.hide();
                                            }, 500, this);
                                        else
                                            this.hide();
                                }, this);
                                I.on('focus', function() {
                                    this._.lG = true;
                                    this.gU();
                                    this.fj(true);
                                }, this);
                                a.event.jP = false;
                                this._.qa = 1;
                            }
                            z.onEscape = k.bind(function() {
                                this.onEscape && this.onEscape();
                            }, this);
                            k.setTimeout(function() {
                                if (F)
                                    G -= B.$.offsetWidth;
                                B.setStyles({
                                    left: G + 'px',
                                    visibility: '',
                                    opacity: '1'
                                });
                                var J = B.getFirst();
                                if (A.oz) {
                                    function K() {
                                        var Q = B.getFirst(),
                                                R = 0,
                                                S = A.element.$;
                                        if (h.gecko || h.opera)
                                            S = S.parentNode;
                                        var T = S.scrollWidth;
                                        if (i && h.version < 10) {
                                            S = S.document.body;
                                            var U = S.getElementsByTagName('a');
                                            for (var V = 0; V < U.length; V++) {
                                                var W = U[V].children[1],
                                                        X = W.scrollWidth + W.offsetLeft - T;
                                                if (X > 0 && X > R)
                                                    R = X;
                                            }
                                        }
                                        T += R;
                                        if (i && h.quirks && T > 0)
                                            T += (Q.$.offsetWidth || 0) - (Q.$.clientWidth || 0);
                                        T += 4;
                                        Q.setStyle('width', T + 'px');
                                        A.element.addClass('cke_frameLoaded');
                                        var Y = A.element.$.scrollHeight;
                                        if (i && h.quirks && Y > 0)
                                            Y += (Q.$.offsetHeight || 0) - (Q.$.clientHeight || 0);
                                        Q.setStyle('height', Y + 'px');
                                        z._.iL.element.setStyle('display', 'none').removeStyle('display');
                                    }
                                    ;
                                    if (z.hm)
                                        K();
                                    else
                                        z.onLoad = K;
                                } else
                                    J.removeStyle('height');
                                var L = z.element,
                                        M = L.getWindow(),
                                        N = M.hV(),
                                        O = M.eR(),
                                        P = {
                                            height: L.$.offsetHeight,
                                            width: L.$.offsetWidth
                                        };
                                if (F ? G < 0 : G + P.width > O.width + N.x)
                                    G += P.width * (F ? 1 : -1);
                                if (H + P.height > O.height + N.y)
                                    H -= P.height;
                                B.setStyles({
                                    top: H + 'px',
                                    left: G + 'px',
                                    opacity: '1'
                                });
                                k.setTimeout(function() {
                                    if (D.ny)
                                        if (h.gecko) {
                                            var Q = C.getParent();
                                            Q.setAttribute('role', 'region');
                                            Q.setAttribute('title', D.ny);
                                            C.setAttribute('role', 'region');
                                            C.setAttribute('title', ' ');
                                        }
                                    if (i && h.quirks)
                                        C.focus();
                                    else
                                        C.$.contentWindow.focus();
                                    if (i && !h.quirks)
                                        this.fj(true);
                                }, 0, this);
                            }, 0, this);
                            this.visible = 1;
                            if (this.onShow)
                                this.onShow.call(this);
                            if (h.ie7Compat || h.ie8 && h.ie6Compat)
                                k.setTimeout(function() {
                                    this._.parentElement.$.style.cssText += '';
                                }, 0, this);
                            s = false;
                        },
                        hide: function() {
                            var u = this;
                            if (u.visible && (!u.onHide || u.onHide.call(u) !== true)) {
                                u.gU();
                                u.element.setStyle('display', 'none');
                                u.visible = 0;
                            }
                        },
                        fj: function(u) {
                            var v = this._.panel;
                            if (u != undefined)
                                v.fj = u;
                            return v.fj;
                        },
                        rA: function(u, v, w, x, y, z) {
                            if (this._.gF == u && u._.panel._.nr == w.dS())
                                return;
                            this.gU();
                            u.onHide = k.bind(function() {
                                k.setTimeout(function() {
                                    if (!this._.lG)
                                        this.hide();
                                }, 0, this);
                            }, this);
                            this._.gF = u;
                            this._.lG = false;
                            u.gf(v, w, x, y, z);
                            if (h.ie7Compat || h.ie8 && h.ie6Compat)
                                setTimeout(function() {
                                    u.element.getChild(0).$.style.cssText += '';
                                }, 100);
                        },
                        gU: function() {
                            var u = this._.gF;
                            if (u) {
                                delete u.onHide;
                                delete this._.gF;
                                u.hide();
                            }
                        }
                    }
                });
            })();
            (function() {
                o.add('formpanel', {
                    bM: ['button'],
                    onLoad: function y() {
                        r();
                    },
                    gr: function A(y) {
                        var z = this;
                        y.on('themeSpace', function C(B) {
                            if (B.data.space == 'mainTop')
                                B.data.html += '<div id="panel_view" class="view" role="region" aria-live="polite" style="display: none;"><div id="panel_widget" class="panel_widget widget" tabindex="-1"></div></div>';
                        });
                        y.on('uiReady', function D(B) {
                            var C = y.document.getById('panel_view').getChild(0);
                            a.ld.bz(y, 'formpanel', z, C);
                        });
                        y.bD('settings', {
                            exec: function(B) {
                                B.oW('requestFilesViewSettingsForm', null, function() {
                                    if (B.cS('settings').bu == a.eV)
                                        setTimeout(function() {
                                            B.ld['formpanel.formpanel'].tools.formNode().eG('input').getItem(0).focus();
                                        }, 0);
                                });
                            }
                        });
                        y.bD('refresh', {
                            exec: function(B) {
                                var C = B.aV;
                                if (C)
                                    B.oW('requestShowFolderFiles', {
                                        folder: C,
                                        lookup: B.ld['filesview.filesview'].data().lookup
                                    }, function() {
                                        setTimeout(function() {
                                            B.ld['filesview.filesview'].bn().focus();
                                        }, 0);
                                    });
                            }
                        });
                        y.bY.add('Settings', a.UI_BUTTON, {
                            label: y.lang.Settings,
                            command: 'settings'
                        });
                        y.bY.add('Refresh', a.UI_BUTTON, {
                            label: y.lang.Refresh,
                            command: 'refresh'
                        });
                        y.cS('refresh').bR(a.aY);
                    }
                });

                function r() {
                    var y = a.ld.hS('formpanel', 'formpanel', {
                        dc: null
                    });
                    y.dT.push(function() {
                        k.mH(this.bn());
                    });
                    y.bh('UnloadForm', ['submit', 'requestUnloadForm'], function A(z) {
                        if (z.name == 'submit' && !this.data().gM)
                            return;
                        z.result = this.oW('beforeUnloadForm', function F(B, C) {
                            var G = this;
                            if (B)
                                return;
                            try {
                                G.bn().getParent().setStyle('display', 'none');
                                G.app.layout.ea(true);
                                if (G.data().dc) {
                                    var D = G.app.cS(G.data().dc);
                                    if (D)
                                        D.bR(a.aS);
                                    G.data().dc = null;
                                }
                                var E = G.tools.formNode();
                                if (E) {
                                    E.mF();
                                    E.remove();
                                }
                                G.tools.releaseDomNodes();
                                G.oW('successUnloadForm', C);
                            } catch (H) {
                                G.oW('failedUnloadForm', C);
                                G.oW('afterUnloadForm', C);
                                throw a.ba(H);
                            }
                        });
                    });
                    y.bh('LoadForm', ['requestLoadForm'], function C(z) {
                        var A = this,
                                B = k.extend({
                                    html: null,
                                    dq: null,
                                    cC: null,
                                    cancelSubmit: 1,
                                    gM: 1,
                                    command: null
                                }, z.data, true);
                        z.result = this.oW('beforeLoadForm', B, function K(D, E) {
                            if (D)
                                return;
                            try {
                                var F = this.bn();
                                F.setHtml(E.html);
                                F.getParent().removeStyle('display');
                                this.app.layout.ea(true);
                                var G = this.tools.formNode();
                                if (G) {
                                    if (E.dq)
                                        if (E.cC)
                                            for (var H in E.cC)
                                                G.on(E.cC[H], E.dq);
                                        else
                                            G.on('submit', E.dq);
                                    if (E.cancelSubmit)
                                        G.on('submit', u);
                                    var I = G.eG('input');
                                    for (var H = 0; H < I.count(); H++) {
                                        if (I.getItem(H).getAttribute('name') == 'cancel') {
                                            I.getItem(H).on('click', function(L) {
                                                A.oW('requestUnloadForm');
                                                L.removeListener();
                                            });
                                            break;
                                        }
                                    }
                                    if (E.cancelSubmit)
                                        G.on('submit', u);
                                }
                                this.data().gM = E.gM;
                                if (E.command) {
                                    var J = this.app.cS(E.command);
                                    if (J)
                                        J.bR(a.eV);
                                    this.data().dc = E.command;
                                }
                                this.oW('successLoadForm', E);
                            } catch (L) {
                                this.oW('failedLoadForm', E);
                                throw a.ba(L);
                            }
                            this.oW('afterLoadForm', E);
                        });
                    });
                    y.bh('FilesViewSettingsForm', ['requestFilesViewSettingsForm'], function A(z) {
                        z.result = this.oW('beforeFilesViewSettingsForm', {}, function F(B, C) {
                            if (B)
                                return;
                            try {
                                if (this.data().dc == 'settings')
                                    this.oW('requestUnloadForm', function() {
                                        this.oW('successFilesViewSettingsForm', C);
                                        this.oW('afterFilesViewSettingsForm', C);
                                    });
                                else {
                                    if (this.data().dc)
                                        this.oW('requestUnloadForm');
                                    var D = this.app.ld['filesview.filesview'].data(),
                                            E = t(this.app.lang, D.dA, D.display, D.cN);
                                    this.oW('requestLoadForm', {
                                        html: E,
                                        dq: k.bind(s, this),
                                        cC: ['click', 'submit'],
                                        command: 'settings'
                                    }, function() {
                                        this.eh.addClass('show_border');
                                        this.app.cg.resizeFormPanel();
                                        this.oW('successFilesViewSettingsForm', C);
                                    });
                                }
                            } catch (G) {
                                this.oW('failedFilesViewSettingsForm', C);
                                this.oW('afterFilesViewSettingsForm', C);
                                throw a.ba(G);
                            }
                        });
                    });
                    y.tools = {
                        formNode: function() {
                            var z = this;
                            if (z.iP === undefined && z.ib.bn().$.childNodes.length)
                                z.iP = x(w(z.ib.bn().$.childNodes, 'form'));
                            return z.iP;
                        },
                        releaseDomNodes: function() {
                            delete this.iP;
                        }
                    };
                }
                ;

                function s(y) {
                    if (y.name == 'submit') {
                        var z = this.app.ld['formpanel.formpanel'],
                                A = z.data();
                        this.oW('requestUnloadForm');
                        this.oW('afterFilesViewSettingsForm', A);
                        return;
                    }
                    var B = y.data.bK(),
                            C = B.getAttribute('name'),
                            D = B.getAttribute('value'),
                            E = B.$.checked;
                    if (B.getName() == 'input')
                        k.setTimeout(function() {
                            var F = this.app.ld['filesview.filesview'],
                                    G = F.data(),
                                    H = {
                                        dA: G.dA,
                                        cN: G.cN,
                                        display: CKFinder.tools.clone(G.display),
                                        lookup: G.lookup
                                    };
                            if (C == 'sortby')
                                G.cN = D;
                            else if (C == 'view_type') {
                                G.dA = D;
                                var I = this.app.document.getById('fs_display_filename');
                                if (D == 'list') {
                                    G.display.filename = true;
                                    I.$.checked = true;
                                    I.$.disabled = true;
                                } else
                                    I.$.disabled = false;
                            } else if (C == 'display_filename') {
                                if (G.dA != 'list')
                                    G.display.filename = !!E;
                            } else if (C == 'display_date')
                                G.display.date = !!E;
                            else if (C == 'display_filesize')
                                G.display.filesize = !!E;
                            var J = (G.dA == 'list' ? 'L' : 'T') + (G.cN == 'size' ? 'S' : G.cN == 'date' ? 'D' : G.cN == 'extension' ? 'E' : 'N') + (G.display.filename ? 'N' : '_') + (G.display.date ? 'D' : '_') + (G.display.filesize ? 'S' : '_');
                            k.setCookie('CKFinder_Settings', J, false);
                            if (H.display.filename != G.display.filename || H.display.date != G.display.date || H.display.filesize != G.display.filesize || H.cN != G.cN || H.dA != G.dA)
                                F.oW('requestRenderFiles', {
                                    mj: F.app.lang.FilesEmpty,
                                    lastView: H
                                });
                        }, 0, this);
                }
                ;

                function t(y, z, A, B) {
                    var C = 'checked="checked"',
                            D = '',
                            E = '',
                            F = '',
                            G = '',
                            H = '',
                            I = '',
                            J = '',
                            K = '',
                            L = '';
                    if (z == 'list')
                        D = C;
                    else
                        E = C;
                    if (A.filename)
                        F = C;
                    if (A.date)
                        G = C;
                    if (A.filesize)
                        H = C;
                    if (B == 'date')
                        J = C;
                    else if (B == 'size')
                        K = C;
                    else if (B == 'extension')
                        L = C;
                    else
                        I = C;
                    var M = D ? ' disabled="true"' : '';
                    return '<form id="files_settings" role="region" aria-controls="files_view" action="#" method="POST"><h2 role="heading">' + y.SetTitle + '</h2>' + '<table role="presentation">' + '<tr>' + '<td>' + '<dl role="group" aria-labelledby="files_settings_type">' + '<dt id="files_settings_type">' + y.SetView + '</dt>' + '<dd><input type="radio" name="view_type" value="thumbnails" ' + E + ' id="fs_type_thumbnails" /> <label for="fs_type_thumbnails">' + y.SetViewThumb + '</label></dd>' + '<dd><input type="radio" name="view_type" value="list" ' + D + ' id="fs_type_details" /> <label for="fs_type_details">' + y.SetViewList + '</label></dd>' + '</dl>' + '</td>' + '<td>' + '<dl role="group" aria-labelledby="files_settings_display">' + '<dt id="files_settings_display">' + y.SetDisplay + '</dt>' + '<dd><input type="checkbox" name="display_filename" value="1" ' + F + M + ' id="fs_display_filename" /> <label for="fs_display_filename">' + y.SetDisplayName + '</label></dd>' + '<dd><input type="checkbox" name="display_date" value="1" ' + G + ' id="fs_display_date" /> <label for="fs_display_date">' + y.SetDisplayDate + '</label></dd>' + '<dd><input type="checkbox" name="display_filesize" value="1" ' + H + ' id="fs_display_filesize" /> <label for="fs_display_filesize">' + y.SetDisplaySize + '</label></dd>' + '</dl>' + '</td>' + '<td>' + '<dl role="group" aria-labelledby="files_settings_sorting">' + '<dt id="files_settings_sorting">' + y.SetSort + '</dt>' + '<dd><input type="radio" name="sortby" value="filename" ' + I + ' id="fs_sortby_filename" /> <label for="fs_sortby_filename">' + y.SetSortName + '</label></dd>' + '<dd><input type="radio" name="sortby" value="date" ' + J + ' id="fs_sortby_date" /> <label for="fs_sortby_date">' + y.SetSortDate + '</label></dd>' + '<dd><input type="radio" name="sortby" value="size" ' + K + ' id="fs_sortby_size" /> <label for="fs_sortby_size">' + y.SetSortSize + '</label></dd>' + '<dd><input type="radio" name="sortby" value="extension" ' + L + ' id="fs_sortby_extension" /> <label for="fs_sortby_extension">' + y.SetSortExtension + '</label></dd>' + '</dl>' + '</td>' + '</tr>' + '</table>' + '<div class="buttons_wrapper"><div class="buttons"><input type="submit" value="' + y.CloseBtn + '" /></div></div>' + '</form>';
                }
                ;

                function u(y) {
                    y.data.preventDefault();
                }
                ;

                function v(y, z) {
                    for (var A in y) {
                        if (z(y[A]) !== undefined)
                            return y[A];
                    }
                    return undefined;
                }
                ;

                function w(y, z, A) {
                    return v(y, function(B) {
                        if (B.tagName && B.tagName.toLowerCase() == z && !A--)
                            return B;
                    });
                }
                ;

                function x(y) {
                    return y ? new m(y) : null;
                }
                ;
            })();
            o.add('keystrokes', {
                eK: function(r) {
                    r.dJ = new a.dJ(r);
                    r.oX = {};
                },
                bz: function(r) {
                    var s = r.config.keystrokes,
                            t = r.config.gN,
                            u = r.dJ.keystrokes,
                            v = r.dJ.gN;
                    for (var w = 0; w < s.length; w++)
                        u[s[w][0]] = s[w][1];
                    for (w = 0; w < t.length; w++)
                        v[t[w]] = 1;
                }
            });
            a.dJ = function(r) {
                var s = this;
                if (r.dJ)
                    return r.dJ;
                s.keystrokes = {};
                s.gN = {};
                s._ = {
                    app: r
                };
                return s;
            };
            (function() {
                var r, s = function(u) {
                    u = u.data;
                    var v = u.db(),
                            w = this.keystrokes[v],
                            x = this._.app;
                    r = x.oW('iK', {
                        keyCode: v
                    }) === true;
                    if (!r) {
                        if (w) {
                            var y = {
                                gJ: 'dJ'
                            };
                            r = x.execCommand(w, y) !== false;
                        }
                        if (!r) {
                            var z = x.oX[v];
                            r = z && z(x) === true;
                            if (!r)
                                r = !!this.gN[v];
                        }
                    }
                    if (r)
                        u.preventDefault(true);
                    return !r;
                }, t = function(u) {
                    if (r) {
                        r = false;
                        u.data.preventDefault(true);
                    }
                };
                a.dJ.prototype = {
                    oA: function(u) {
                        u.on('keydown', s, this);
                        if (h.opera || h.gecko && h.mac)
                            u.on('keypress', t, this);
                    }
                };
            })();
            n.gN = [];
            n.keystrokes = [
                [a.eJ + 119, 'foldertreeFocus'],
                [a.eJ + 120, 'filesviewFocus'],
                [a.eJ + 121, 'hW'],
                [a.eJ + 85, 'upload'],
                [a.dy + 121, 'bj'],
                [a.bP + a.dy + 121, 'bj']
            ];
            o.add('menu', {
                eK: function(r) {
                    var s = r.config.nj.split(','),
                            t = {};
                    for (var u = 0; u < s.length; u++)
                        t[s[u]] = u + 1;
                    r._.iA = t;
                    r._.iG = {};
                },
                bM: ['floatpanel']
            });
            k.extend(a.application.prototype, {
                dZ: function(r, s) {
                    this._.iA[r] = s || 100;
                },
                gp: function(r, s) {
                    if (this._.iA[s.group])
                        this._.iG[r] = new a.iD(this, r, s);
                },
                eU: function(r) {
                    for (var s in r)
                        this.gp(s, r[s]);
                },
                mh: function(r) {
                    return this._.iG[r];
                }
            });
            (function() {
                a.menu = k.createClass({
                    $: function(s, t) {
                        var u = this;
                        u.id = 'cke_' + k.getNextNumber();
                        u.app = s;
                        u.items = [];
                        u._.hx = t || 1;
                    },
                    _: {
                        jK: function(s) {
                            var y = this;
                            var t = y._.oM,
                                    u = y.items[s],
                                    v = u.hQ && u.hQ();
                            if (!v) {
                                y._.panel.gU();
                                return;
                            }
                            if (t)
                                t.ih();
                            else {
                                t = y._.oM = new a.menu(y.app, y._.hx + 1);
                                t.parent = y;
                                t.onClick = k.bind(y.onClick, y);
                            }
                            for (var w in v)
                                t.add(y.app.mh(w));
                            var x = y._.panel.iv(y.id).element.getDocument().getById(y.id + String(s));
                            t.show(x, 2);
                        }
                    },
                    ej: {
                        add: function(s) {
                            if (!s.fE)
                                s.fE = this.items.length;
                            this.items.push(s);
                        },
                        ih: function() {
                            this.items = [];
                        },
                        show: function(s, t, u, v) {
                            var w = this.items,
                                    x = this.app,
                                    y = this._.panel,
                                    z = this._.element;
                            if (!y) {
                                y = this._.panel = new p.pY(this.app, this.app.document.bH(), {
                                    css: [],
                                    hx: this._.hx - 1,
                                    className: x.iy + ' cke_contextmenu'
                                }, this._.hx);
                                y.onEscape = k.bind(function() {
                                    this.onEscape && this.onEscape();
                                    this.hide();
                                }, this);
                                y.onHide = k.bind(function() {
                                    this.onHide && this.onHide();
                                }, this);
                                var A = y.qq(this.id);
                                A.oz = true;
                                var B = A.jQ;
                                B[40] = 'next';
                                B[9] = 'next';
                                B[38] = 'prev';
                                B[a.dy + 9] = 'prev';
                                B[32] = 'click';
                                B[39] = 'click';
                                z = this._.element = A.element;
                                z.addClass(x.iy);
                                var C = z.getDocument();
                                C.bH().setStyle('overflow', 'hidden');
                                C.eG('html').getItem(0).setStyle('overflow', 'hidden');
                                this._.qz = k.addFunction(function(I) {
                                    var J = this;
                                    clearTimeout(J._.jI);
                                    J._.jI = k.setTimeout(J._.jK, x.config.ob, J, [I]);
                                }, this);
                                this._.qm = k.addFunction(function(I) {
                                    clearTimeout(this._.jI);
                                }, this);
                                this._.ql = k.addFunction(function(I) {
                                    var K = this;
                                    var J = K.items[I];
                                    if (J.bu == a.aY) {
                                        K.hide();
                                        return;
                                    }
                                    if (J.hQ)
                                        K._.jK(I);
                                    else
                                        K.onClick && K.onClick(J);
                                }, this);
                            }
                            r(w);
                            var D = ['<div class="cke_menu">'],
                                    E = w.length,
                                    F = E && w[0].group;
                            for (var G = 0; G < E; G++) {
                                var H = w[G];
                                if (F != H.group) {
                                    D.push('<div class="cke_menuseparator"></div>');
                                    F = H.group;
                                }
                                H.er(this, G, D);
                            }
                            D.push('</div>');
                            z.setHtml(D.join(''));
                            if (this.parent)
                                this.parent._.panel.rA(y, this.id, s, t, u, v);
                            else
                                y.gf(this.id, s, t, u, v);
                            x.oW('menuShow', [y]);
                        },
                        hide: function() {
                            this._.panel && this._.panel.hide();
                        }
                    }
                });

                function r(s) {
                    s.sort(function(t, u) {
                        if (t.group < u.group)
                            return -1;
                        else if (t.group > u.group)
                            return 1;
                        return t.fE < u.fE ? -1 : t.fE > u.fE ? 1 : 0;
                    });
                }
                ;
            })();
            a.iD = k.createClass({
                $: function(r, s, t) {
                    var u = this;
                    k.extend(u, t, {
                        fE: 0,
                        className: 'cke_button_' + s
                    });
                    u.group = r._.iA[u.group];
                    u.app = r;
                    u.name = s;
                },
                ej: {
                    er: function(r, s, t) {
                        var A = this;
                        var u = r.id + String(s),
                                v = typeof A.bu == 'undefined' ? a.aS : A.bu,
                                w = ' cke_' + (v == a.eV ? 'on' : v == a.aY ? 'disabled' : 'off'),
                                x = A.label;
                        if (v == a.aY)
                            x = A.app.lang.common.unavailable.replace('%1', x);
                        if (A.className)
                            w += ' ' + A.className;
                        var y = A.hQ;
                        t.push('<span class="cke_menuitem"><a id="', u, '" class="', w, '" href="javascript:void(\'', (A.label || '').replace("'", ''), '\')" title="', A.label, '" tabindex="-1"_cke_focus=1 hidefocus="true" role="menuitem"' + (y ? 'aria-haspopup="true"' : '') + (v == a.aY ? 'aria-disabled="true"' : '') + (v == a.eV ? 'aria-pressed="true"' : ''));
                        if (h.opera || h.gecko && h.mac)
                            t.push(' onkeypress="return false;"');
                        if (h.gecko)
                            t.push(' onblur="this.style.cssText = this.style.cssText;"');
                        var z = (A.rD || 0) * -16;
                        t.push(' onmouseover="CKFinder.tools.callFunction(', r._.qz, ',', s, ');" onmouseout="CKFinder.tools.callFunction(', r._.qm, ',', s, ');" onclick="CKFinder.tools.callFunction(', r._.ql, ',', s, '); return false;"><span class="cke_icon_wrapper"><span class="cke_icon"' + (A.icon ? ' style="background-image:url(' + a.getUrl(A.icon) + ');background-position:0 ' + z + 'px;"' : '') + '></span></span>' + '<span class="cke_label">');
                        if (A.hQ)
                            t.push('<span class="cke_menuarrow"></span>');
                        t.push(x, '</span></a></span>');
                    }
                }
            });
            n.ob = 400;
            n.nj = '';
            (function() {
                function r(u) {
                    if (h.opera)
                        u.setStyle('overflow', 'hidden');
                    u.on('touchstart', function(v) {
                        var w = v.data.$.touches[0];
                        if (u.interval) {
                            window.clearInterval(u.interval);
                            delete u.interval;
                        }
                        u.lL = u.$.scrollTop;
                        u.nx = u.$.scrollLeft;
                        u.mP = w.pageY;
                        u.na = w.pageX;
                        u.mO = new Date();
                    });
                    u.on('touchmove', function(v) {
                        var w = v.data,
                                x = w.$.touches[0];
                        if (s(u, x.pageX, x.pageY))
                            w.preventDefault();
                    });
                    u.on('touchend', function(v) {
                        var w = v.data,
                                x = w.$.changedTouches[0];
                        if (s(u, x.pageX, x.pageY)) {
                            w.preventDefault();
                            var y = (new Date() - u.mO) / 100,
                                    z = x.pageX - u.na,
                                    A = x.pageY - u.mP;
                            u.mK = z / y;
                            u.nu = A / y;
                            u.jy = x.pageX;
                            u.mv = x.pageY;
                            u.nf = 0;
                            u.interval = window.setInterval(function() {
                                t(u);
                            }, 100);
                        }
                    });
                }
                ;

                function s(u, v, w) {
                    var x = Math.round(v - u.na),
                            y = Math.round(w - u.mP),
                            z = u.nx - x,
                            A = u.lL - y;
                    if (u.$.scrollLeft == z && u.$.scrollTop == A)
                        return false;
                    u.$.scrollLeft = z;
                    u.$.scrollTop = A;
                    if (Math.abs(x) > Math.abs(y))
                        return u.$.scrollLeft == z;
                    else
                        return u.$.scrollTop == A;
                }
                ;

                function t(u) {
                    var v = 7,
                            w = Math.cos(u.nf / v * Math.PI / 2);
                    u.jy += u.mK * w;
                    u.mv += u.nu * w;
                    if (u.nf++ > v || !s(u, u.jy, u.mv)) {
                        window.clearInterval(u.interval);
                        delete u.interval;
                        return;
                    }
                }
                ;
                o.add('mobile', {
                    bM: ['foldertree', 'filesview'],
                    bz: function w(u) {
                        var v = 'ontouchstart' in window;
                        if (!h.isMobile && !v)
                            return;
                        u.config.showContextMenuArrow = true;
                        if (!h.isMobile)
                            return;
                        u.on('uiReady', function y(x) {
                            if (h.webkit && h.version < 534 || h.opera) {
                                r(u.layout.pS());
                                r(u.layout.pn());
                            }
                            u.hs = function(z, A, B, C) {
                                var D = window.prompt(A, B);
                                if (D !== null)
                                    C(D);
                            };
                            u.msgDialog = function(z, A, B) {
                                window.alert(A);
                                if (B)
                                    B();
                            };
                            u.fe = function(z, A, B) {
                                if (window.confirm(A))
                                    B();
                            };
                        }, null, null, 20);
                    }
                });
            })();
            o.add('panel', {
                eK: function(r) {
                    r.bY.kd(a.UI_PANEL, p.panel.dq);
                }
            });
            a.UI_PANEL = 2;
            p.panel = function(r, s, t) {
                var v = this;
                if (s)
                    k.extend(v, s);
                k.extend(v, {
                    className: ''
                });
                var u = a.basePath;
                k.extend(v.css, [u + 'skins/' + t + '/uipanel.css']);
                v.id = k.getNextNumber();
                v.document = r;
                v._ = {
                    iq: {}
                };
            };
            p.panel.dq = {
                create: function(r) {
                    return new p.panel(r);
                }
            };
            p.panel.prototype = {
                nt: function(r) {
                    var s = [];
                    this.er(r, s);
                    return s.join('');
                },
                er: function(r, s) {
                    var w = this;
                    var t = 'cke_' + w.id;
                    s.push('<div class="', r.iy, ' cke_compatibility" lang="', r.langCode, '" role="presentation" style="display:none;z-index:' + (r.config.baseFloatZIndex + 1) + '">' + '<div' + ' id="', t, '"', ' dir="', r.lang.dir, '"', ' role="presentation" class="cke_panel cke_', r.lang.dir);
                    if (w.className)
                        s.push(' ', w.className);
                    s.push('">');
                    if (w.lE || w.css.length) {
                        s.push('<iframe id="', t, '_frame" frameborder="0" src="');
                        var u = h.isCustomDomain(),
                                v = 'document.open();' + (u ? 'document.domain="' + window.document.domain + '";' : '') + 'document.close();';
                        s.push(i ? 'javascript:void(function(){' + encodeURIComponent(v) + '}())' : '');
                        s.push('"></iframe>');
                    }
                    s.push('</div></div>');
                    return t;
                },
                oU: function() {
                    var r = this._.rE;
                    if (!r) {
                        if (this.lE || this.css.length) {
                            var s = this.document.getById('cke_' + this.id + '_frame'),
                                    t = s.getParent(),
                                    u = t.getAttribute('dir'),
                                    v = t.getParent().getAttribute('class').split(' ')[0],
                                    w = t.getParent().getAttribute('lang'),
                                    x = s.getFrameDocument();
                            x.$.open();
                            if (h.isCustomDomain())
                                x.$.domain = document.domain;
                            var y = k.addFunction(k.bind(function(B) {
                                this.hm = true;
                                if (this.onLoad)
                                    this.onLoad();
                            }, this)),
                                    z = x.getWindow();
                            z.$.CKFinder = CKFinder;
                            var A = h.cssClass.replace(/browser_quirks|browser_iequirks/g, '');
                            x.$.write("<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'><html dir=\"" + u + '" class="' + v + '_container" lang="' + w + '">' + '<head>' + '<style>.' + v + '_container{visibility:hidden}</style>' + '</head>' + '<body class="cke_' + u + ' cke_panel_frame ' + A + ' cke_compatibility" style="margin:0;padding:0"' + ' onload="var ckfinder = window.CKFinder || window.parent.CKFinder; ckfinder && ckfinder.tools.callFunction(' + y + ');">' + '</body>' + '<link type="text/css" rel=stylesheet href="' + this.css.join('"><link type="text/css" rel="stylesheet" href="') + '">' + '</html>');
                            x.$.close();
                            z.$.CKFinder = CKFinder;
                            x.on('keydown', function(B) {
                                var D = this;
                                var C = B.data.db();
                                if (D._.onKeyDown && D._.onKeyDown(C) === false) {
                                    B.data.preventDefault();
                                    return;
                                }
                                if (C == 27)
                                    D.onEscape && D.onEscape();
                            }, this);
                            r = x.bH();
                        } else
                            r = this.document.getById('cke_' + this.id);
                        this._.rE = r;
                    }
                    return r;
                },
                qq: function(r, s) {
                    var t = this;
                    s = t._.iq[r] = s || new p.panel.block(t.oU());
                    if (!t._.iL)
                        t.gf(r);
                    return s;
                },
                iv: function(r) {
                    return this._.iq[r];
                },
                gf: function(r) {
                    var v = this;
                    var s = v._.iq,
                            t = s[r],
                            u = v._.iL;
                    if (u)
                        u.hide();
                    v._.iL = t;
                    t._.cQ = -1;
                    v._.onKeyDown = t.onKeyDown && k.bind(t.onKeyDown, t);
                    t.show();
                    return t;
                }
            };
            p.panel.block = k.createClass({
                $: function(r) {
                    var s = this;
                    s.element = r.append(r.getDocument().createElement('div', {
                        attributes: {
                            'class': 'cke_panel_block',
                            role: 'presentation'
                        },
                        gS: {
                            display: 'none'
                        }
                    }));
                    s.jQ = {};
                    s._.cQ = -1;
                    s.element.hX();
                },
                _: {},
                ej: {
                    show: function() {
                        this.element.setStyle('display', '');
                    },
                    hide: function() {
                        var r = this;
                        if (!r.onHide || r.onHide.call(r) !== true)
                            r.element.setStyle('display', 'none');
                    },
                    onKeyDown: function(r) {
                        var w = this;
                        var s = w.jQ[r];
                        switch (s) {
                            case 'next':
                                var t = w._.cQ,
                                        u = w.element.eG('a'),
                                        v;
                                while (v = u.getItem(++t)) {
                                    if (v.getAttribute('_cke_focus') && v.$.offsetWidth) {
                                        w._.cQ = t;
                                        v.focus();
                                        break;
                                    }
                                }
                                return false;
                            case 'prev':
                                t = w._.cQ;
                                u = w.element.eG('a');
                                while (t > 0 && (v = u.getItem(--t))) {
                                    if (v.getAttribute('_cke_focus') && v.$.offsetWidth) {
                                        w._.cQ = t;
                                        v.focus();
                                        break;
                                    }
                                }
                                return false;
                            case 'click':
                                t = w._.cQ;
                                v = t >= 0 && w.element.eG('a').getItem(t);
                                if (v)
                                    v.$.click ? v.$.click() : v.$.onclick();
                                return false;
                        }
                        return true;
                    }
                }
            });
            o.add('resize', {
                bz: function(r) {
                    var s = r.config;
                    if (s.nB)
                        r.on('uiReady', function() {
                            var t = null,
                                    u, v;

                            function w(y) {
                                r.document.bH().addClass('during_sidebar_resize');
                                var z = y.data.$.screenX - u.x,
                                        A = v.width + z * (r.lang.dir == 'rtl' ? -1 : 1);
                                r.nJ(Math.max(s.nN, Math.min(A, s.nC)));
                            }
                            ;

                            function x(y) {
                                r.document.bH().removeClass('during_sidebar_resize');
                                a.document.removeListener('mousemove', w);
                                a.document.removeListener('mouseup', x);
                                if (r.document) {
                                    r.document.removeListener('mousemove', w);
                                    r.document.removeListener('mouseup', x);
                                }
                            }
                            ;
                            r.layout.dV().on('mousedown', function(y) {
                                if (!t)
                                    t = r.layout.dV();
                                if (y.data.bK().$ != t.$)
                                    return;
                                v = {
                                    width: t.$.offsetWidth || 0
                                };
                                u = {
                                    x: y.data.$.screenX
                                };
                                a.document.on('mousemove', w);
                                a.document.on('mouseup', x);
                                if (r.document) {
                                    r.document.on('mousemove', w);
                                    r.document.on('mouseup', x);
                                }
                            });
                        });
                }
            });
            n.nN = 120;
            n.nC = 500;
            n.nB = true;
            (function() {
                o.add('status', {
                    bM: ['filesview'],
                    onLoad: function u() {
                        r();
                    },
                    gr: function w(u) {
                        var v = this;
                        u.on('themeSpace', function y(x) {
                            if (x.data.space == 'mainBottom')
                                x.data.html += '<div id="status_view" class="view" role="status"></div>';
                        });
                        u.on('uiReady', function B(x) {
                            var y = u.document.getById('status_view'),
                                    z = u.ld['filesview.filesview'],
                                    A = a.ld.bz(u, 'status', v, y, {
                                        parent: z
                                    });
                            if (z.app == u) {
                                z.on('successSelectFile', function D(C) {
                                    A.oW('requestShowFileInfo', C.data);
                                });
                                z.on('successRenderFiles', function E(C) {
                                    var D = {
                                        folder: C.data.folder,
                                        ib: z
                                    };
                                    A.oW('requestShowFolderInfo', D);
                                });
                            }
                            u.on('afterCommandExecDefered', function E(C) {
                                if (C.data.name == 'RemoveFile') {
                                    var D = {
                                        folder: C.data.folder,
                                        ib: z
                                    };
                                    A.oW('requestShowFolderInfo', D);
                                }
                            });
                            A.on('afterShowFileInfo', function D(C) {
                                if (this.bn().getText())
                                    return;
                                A.oW('requestShowFolderInfo', {
                                    ib: z,
                                    folder: z.data().folder
                                });
                            });
                        });
                    }
                });

                function r() {
                    var u = a.ld.hS('status', 'status');
                    u.bh('ShowFileInfo', ['requestShowFileInfo'], function w(v) {
                        v.result = this.oW('beforeShowFileInfo', v.data, function B(x, y) {
                            var C = this;
                            if (x)
                                return;
                            var z = y.file;
                            try {
                                var A = z ? s(z, C.app.lang) : '';
                                C.bn().setHtml(A);
                                C.oW('successShowFileInfo', y);
                            } catch (D) {
                                C.oW('failedShowFileInfo', y);
                                throw a.ba(D);
                            }
                            C.oW('afterShowFileInfo', y);
                        });
                    });
                    u.bh('ShowFolderInfo', ['requestShowFolderInfo'], function w(v) {
                        v.result = this.oW('beforeShowFolderInfo', v.data, function B(x, y) {
                            var C = this;
                            if (x)
                                return;
                            var z = y.folder;
                            try {
                                var A = t(v.data.ib.data().shownFiles.length, C.app.lang);
                                C.bn().setHtml(A);
                                C.oW('successShowFolderInfo', y);
                            } catch (D) {
                                C.oW('failedShowFolderInfo', y);
                                throw a.ba(D);
                            }
                            C.oW('afterShowFolderInfo', y);
                        });
                    });
                }
                ;

                function s(u, v) {
                    return '<p>' + u.name + ' (' + k.formatSize(u.size, v, true) + ', ' + u.dateF + ')</p>';
                }
                ;

                function t(u, v) {
                    var w;
                    if (u === 0)
                        w = v.FilesCountEmpty;
                    else if (u == 1)
                        w = v.FilesCountOne;
                    else
                        w = v.FilesCountMany.replace('%1', u);
                    return '<p>' + k.htmlEncode(w) + '</p>';
                }
                ;
            })();
            (function() {
                var r = function() {
                    this.fk = [];
                    this.pZ = false;
                };
                r.prototype.focus = function() {
                    for (var t = 0, u; u = this.fk[t++]; )
                        for (var v = 0, w; w = u.items[v++]; ) {
                            if (w.focus) {
                                w.focus();
                                return;
                            }
                        }
                };
                var s = {
                    hW: {
                        iH: {
                            qt: 1,
                            source: 1
                        },
                        exec: function(t) {
                            if (t.dh) {
                                t.dh.pZ = true;
                                if (i)
                                    setTimeout(function() {
                                        t.dh.focus();
                                    }, 100);
                                else
                                    t.dh.focus();
                            }
                        }
                    }
                };
                o.add('toolbar', {
                    bM: ['formpanel'],
                    bz: function(t) {
                        var u = function(v, w) {
                            switch (w) {
                                case t.lang.dir == 'rtl' ? 37 :
                                        39 :
                                    while ((v = v.next || v.toolbar.next && v.toolbar.next.items[0]) && !v.focus) {
                                    }
                                    if (v)
                                        v.focus();
                                    else
                                        t.dh.focus();
                                    return false;
                                case t.lang.dir == 'rtl' ? 39 :
                                        37 :
                                    while ((v = v.previous || v.toolbar.previous && v.toolbar.previous.items[v.toolbar.previous.items.length - 1]) && !v.focus) {
                                    }
                                    if (v)
                                        v.focus();
                                    else {
                                        var x = t.dh.fk[t.dh.fk.length - 1].items;
                                        x[x.length - 1].focus();
                                    }
                                    return false;
                                case 27:
                                    t.focus();
                                    return false;
                                case 13:
                                case 32:
                                    v.lc();
                                    return false;
                            }
                            return true;
                        };
                        t.on('themeSpace', function(v) {
                            if (v.data.space == 'mainTop') {
                                t.dh = new r();
                                var w = 'cke_' + k.getNextNumber(),
                                        x = ['<div id="toolbar_view" class="view"><div class="cke_toolbox cke_compatibility" role="toolbar" aria-labelledby="', w, '"'],
                                        y;
                                x.push('>');
                                x.push('<span id="', w, '" class="cke_voice_label">', t.lang.toolbar, '</span>');
                                var z = t.dh.fk,
                                        A = t.config.toolbar instanceof Array ? t.config.toolbar : t.config['toolbar_' + t.config.toolbar];
                                for (var B = 0; B < A.length; B++) {
                                    var C = A[B];
                                    if (!C)
                                        continue;
                                    var D = 'cke_' + k.getNextNumber(),
                                            E = {
                                                id: D,
                                                items: []
                                            };
                                    if (y) {
                                        x.push('</div>');
                                        y = 0;
                                    }
                                    if (C === '/') {
                                        x.push('<div class="cke_break"></div>');
                                        continue;
                                    }
                                    x.push('<span id="', D, '" class="cke_toolbar" role="presentation"><span class="cke_toolbar_start"></span>');
                                    var F = z.push(E) - 1;
                                    if (F > 0) {
                                        E.previous = z[F - 1];
                                        E.previous.next = E;
                                    }
                                    for (var G = 0; G < C.length; G++) {
                                        var H, I = C[G];
                                        if (I == '-')
                                            H = p.separator;
                                        else
                                            H = t.bY.create(I);
                                        if (H) {
                                            if (H.canGroup) {
                                                if (!y) {
                                                    x.push('<span class="cke_toolgroup">');
                                                    y = 1;
                                                }
                                            } else if (y) {
                                                x.push('</span>');
                                                y = 0;
                                            }
                                            var J = H.er(t, x);
                                            F = E.items.push(J) - 1;
                                            if (F > 0) {
                                                J.previous = E.items[F - 1];
                                                J.previous.next = J;
                                            }
                                            J.toolbar = E;
                                            J.onkey = u;
                                        }
                                    }
                                    if (y) {
                                        x.push('</span>');
                                        y = 0;
                                    }
                                    x.push('<span class="cke_toolbar_end"></span></span>');
                                }
                                if (t.search)
                                    t.search.er(t, x);
                                x.push('</div></div>');
                                v.data.html += x.join('');
                            }
                        });
                        t.bD('hW', s.hW);
                    }
                });
            })();
            p.separator = {
                er: function(r, s) {
                    s.push('<span class="cke_separator"></span>');
                    return {};
                }
            };
            n.toolbar_Basic = [
                ['Upload', 'Refresh']
            ];
            n.toolbar_Full = [
                ['Upload', 'Refresh', 'Settings', 'Maximize', 'Help']
            ];
            n.toolbar = 'Full';
            (function() {
                o.add('tools', {
                    eK: function s(r) {
                        this.app = r;
                    },
                    addTool: function(r, s) {
                        var t = 'tool_' + k.getNextNumber();
                        r = s ? '<div id="' + t + '" class="view tool_panel" tabindex="0" style="display: none;">' + r + '</div>' : '<div id="' + t + '" class="tool" style="display: none;">' + r + '</div>';
                        this.app.layout.dV().getChild(0).appendHtml(r);
                        return t;
                    },
                    addToolPanel: function(r) {
                        r = r || '';
                        var s = this.addTool(r, 1),
                                t = this.app.layout.dV().getChild(0).dB();
                        k.mH(t);
                        return s;
                    },
                    hideTool: function(r) {
                        this.app.document.getById(r).setStyle('display', 'none');
                        this.app.layout.ea(true);
                    },
                    showTool: function(r) {
                        this.app.document.getById(r).removeStyle('display');
                        this.app.layout.ea(true);
                    },
                    removeTool: function(r) {
                        this.hideTool(r);
                        this.app.document.getById(r).remove();
                    }
                });
            })();
            (function() {
                o.add('uploadform', {
                    bM: ['formpanel', 'button'],
                    readOnly: false,
                    md: function() {
                        if (!h.webkit)
                            return true;
                        var s = document.createElement('input');
                        s.setAttribute('type', 'file');
                        return s.disabled === false;
                    },
                    onLoad: function s() {
                        if (!this.md())
                            return;
                        r();
                    },
                    gr: function t(s) {
                        if (!this.md())
                            return;
                        s.bD('upload', {
                            exec: function(u) {
                                u.oW('requestUploadFileForm', null, function() {
                                    var v = u.ld['formpanel.formpanel'].tools.formNode(),
                                            w = u.cg.inPopup && i && h.version > 8;
                                    if (w)
                                        v && v.submit();
                                    if (u.cS('upload').bu == a.eV)
                                        setTimeout(function() {
                                            if (v) {
                                                var x = v.eG('input').getItem(0);
                                                if (!w)
                                                    x.on('change', function() {
                                                        if (x.getValue())
                                                            for (var y = 0; y < v.$.elements.length; y++) {
                                                                var z = v.$.elements[y];
                                                                if (z.nodeName == 'INPUT' && z.type == 'submit')
                                                                    z.click();
                                                            }
                                                    });
                                                if (x.$.click)
                                                    x.$.click();
                                                else
                                                    x.focus();
                                            }
                                        }, 0);
                                });
                            }
                        });
                        s.bY.add('Upload', a.UI_BUTTON, {
                            label: s.lang.Upload,
                            command: 'upload'
                        });
                        s.on('appReady', function(u) {
                            s.ld['filesview.filesview'].on('successShowFolderFiles', function z(v) {
                                var w = this.tools.currentFolder(),
                                        x = this.app.cS('upload');
                                if (w && w.acl.fileUpload) {
                                    if (x.bu == a.aY)
                                        x.bR(a.aS);
                                } else {
                                    var y = s.ld['formpanel.formpanel'];
                                    if (y.data().dc == 'upload')
                                        y.oW('requestUnloadForm');
                                    x.bR(a.aY);
                                }
                            });
                        });
                    }
                });

                function r() {
                    var s = a.ld.bX['formpanel.formpanel'];
                    if (!s)
                        return;
                    s.bh('UploadFileForm', ['requestUploadFileForm'], function z(w) {
                        var x = this.app.aV,
                                y = this;
                        this.oW('beforeUploadFileForm', {
                            folder: x,
                            step: 1
                        }, function F(A, B) {
                            if (A || t())
                                return;
                            var C = this.data(),
                                    D = B.folder,
                                    E = 0;
                            if (!D) {
                                this.app.msgDialog('', this.app.lang.UploadNoFolder);
                                E = 1;
                            }
                            if (!E && !D.acl.fileUpload) {
                                this.app.msgDialog('', this.app.lang.UploadNoPerms);
                                E = 1;
                            }
                            if (E) {
                                this.oW('failedUploadFileForm');
                                this.oW('afterUploadFileForm');
                                return;
                            }
                            this.oW('beforeUploadFileForm', {
                                folder: D,
                                step: 2
                            }, function O(G, H) {
                                try {
                                    if (C.dc == 'upload')
                                        this.oW('requestUnloadForm', function() {
                                            this.app.cS('upload').bR(a.aS);
                                            this.oW('successUploadFileForm', H);
                                            this.oW('afterUploadFileForm', H);
                                        });
                                    else {
                                        if (C.dc)
                                            this.oW('requestUnloadForm');
                                        var I = this.tools.qL(),
                                                J = this.app.connector.composeUrl('FileUpload', {}, D.type, D),
                                                K = v(this.app, I.$.id, J),
                                                L = this;
                                        this.oW('requestLoadForm', {
                                            html: K,
                                            dq: k.bind(function(P) {
                                                return u.call(L, P, D);
                                            }),
                                            cC: ['submit'],
                                            cancelSubmit: 0,
                                            gM: 0,
                                            command: 'upload'
                                        }, function() {
                                            this.eh.addClass('show_border');
                                            H.step = 1;
                                            this.oW('successUploadFileForm', H);
                                        });

                                        function M(P) {
                                            if (P.data.folder && P.data.folder.acl.fileUpload) {
                                                var Q = y.tools.qO();
                                                y.oW('requestUnloadForm');
                                                y.oW('requestUploadFileForm', function S() {
                                                    var R = y.tools.qO();
                                                    Q.kB(R);
                                                    R.remove();
                                                    delete y.tools.jj;
                                                });
                                            }
                                        }
                                        ;
                                        var N = this.app.ld['filesview.filesview'];
                                        N.on('successShowFolderFiles', M);
                                        this.on('requestUnloadForm', function Q(P) {
                                            P.removeListener();
                                            N.removeListener('successShowFolderFiles', M);
                                        });
                                    }
                                } catch (P) {
                                    this.oW('failedUploadFileForm', H);
                                    this.oW('afterUploadFileForm', H);
                                    throw a.ba(P);
                                }
                            });
                        });
                    });

                    function t() {
                        var w = "\122MR\110\131\065\121\064S,\107GYXT\123B\114A,Q\1238\106\064\132F\125\112";
                        return a.bF.length > 0 && w.indexOf(a.bF.substr(0, 9)) != -1;
                    }
                    ;
                    s.tools.releaseDomNodes = k.override(s.tools.releaseDomNodes, function(w) {
                        return function() {
                            var x = this;
                            w.apply(x, arguments);
                            delete x.jj;
                            delete x.jc;
                            if (x.gq !== undefined) {
                                x.gq.remove();
                                delete x.gq;
                            }
                        };
                    });
                    s.tools.qB = function() {
                        var w = this;
                        if (w.jc === undefined)
                            w.jc = w.ib.bn().getChild([0, 2]);
                        return w.jc;
                    };
                    s.tools.qO = function() {
                        var w = this;
                        if (w.jj === undefined)
                            w.jj = w.ib.bn().getChild([0, 1, 0]);
                        return w.jj;
                    };
                    s.tools.qL = function() {
                        var A = this;
                        if (A.gq === undefined) {
                            var w = h.isCustomDomain(),
                                    x = 'ckf_' + k.getNextNumber(),
                                    y = '<iframe id="' + x + '"' + ' name="' + x + '"' + ' style="display:none"' + ' frameBorder="0"' + (w ? " src=\"javascript:void((function(){document.open();document.domain='" + document.domain + "';" + 'document.close();' + '})())"' : '') + ' tabIndex="-1"' + ' allowTransparency="true"' + '></iframe>',
                                    z = A.ib.app.document.bH();
                            z.appendHtml(y);
                            A.gq = z.dB();
                        }
                        return A.gq;
                    };

                    function u(w, x) {
                        var y = this,
                                z = y.data(),
                                A = 1,
                                B = this.tools.qO(),
                                C = B && B.$.value;
                        if (!C.length) {
                            w.data.preventDefault(true);
                            this.oW('failedUploadFileForm');
                            this.oW('afterUploadFileForm');
                            return false;
                        }
                        var D = C.match(/\.([^\.]+)\s*$/)[1];
                        if (!D || !x.getResourceType().isExtensionAllowed(D)) {
                            w.data.preventDefault();
                            y.app.msgDialog('', y.app.lang.UploadExtIncorrect);
                        } else
                            A = 0;
                        if (A) {
                            w.data.preventDefault(true);
                            this.oW('failedUploadFileForm');
                            this.oW('afterUploadFileForm');
                            return false;
                        }
                        var E = y.app.document.getWindow().$;
                        E.OnUploadCompleted = function(F, G) {
                            var H = {
                                step: 3,
                                filename: F,
                                folder: x
                            };
                            if (G && !F) {
                                y.app.msgDialog('', G);
                                var I = y.tools.qB();
                                I.setStyle('display', 'none');
                                I.getChild(1).setText('');
                                I.getChild(2).setText('');
                                y.oW('failedUploadFileForm', H);
                            } else {
                                if (G)
                                    y.app.msgDialog('', G);
                                if (y.app.aV == x)
                                    y.app.oW('requestShowFolderFiles', {
                                        folder: x,
                                        mw: F
                                    });
                                y.oW('requestUnloadForm');
                                y.oW('successUploadFileForm', H);
                            }
                            y.oW('afterUploadFileForm', H);
                            try {
                                delete E.OnUploadCompleted;
                            } catch (J) {
                                E.OnUploadCompleted = undefined;
                            }
                        };
                        a.log('[UPLOADFORM] Starting IFRAME file upload.');
                        this.oW('successUploadFileForm', {
                            step: 2
                        });
                        return true;
                    }
                    ;

                    function v(w, x, y) {
                        return '<form enctype="multipart/form-data" id="upload_form" role="region" action="' + y + '" method="POST" target="' + x + '">' + '<h2 role="heading">' + w.lang.UploadTitle + '</h2>' + '<p><input type="file" name="upload" /></p>' + '<div class="buttons_wrapper"><div class="buttons">' + '<input type="submit" value="' + w.lang.UploadBtn + '" />' + '<input type="button" name="cancel" value="' + w.lang.UploadBtnCancel + '" />' + '</div></div>' + '</form>';
                    }
                    ;
                }
                ;
            })();
            (function() {
                function r(s, t) {
                    var u = 'undefined',
                            v = 'object',
                            w = 'Shockwave Flash',
                            x = 'ShockwaveFlash.ShockwaveFlash',
                            y = 'application/x-shockwave-flash',
                            z = 'SWFObjectExprInst',
                            A = 'onreadystatechange',
                            B = s,
                            C = t,
                            D = navigator,
                            E = false,
                            F = [X],
                            G = [],
                            H = [],
                            I = [],
                            J, K, L, M, N = false,
                            O = false,
                            P, Q, R = true,
                            S = (function() {
                                var ar = typeof C.getElementById != u && typeof C.getElementsByTagName != u && typeof C.createElement != u,
                                        as = D.userAgent.toLowerCase(),
                                        at = D.platform.toLowerCase(),
                                        au = at ? /win/.test(at) : /win/.test(as),
                                        av = at ? /mac/.test(at) : /mac/.test(as),
                                        aw = /webkit/.test(as) ? parseFloat(as.replace(/^.*webkit\/(\d+(\.\d+)?).*$/, '$1')) : false,
                                        ax = !+'\v1',
                                        ay = [0, 0, 0],
                                        az = null;
                                if (typeof D.plugins != u && typeof D.plugins[w] == v) {
                                    az = D.plugins[w].description;
                                    if (az && !(typeof D.mimeTypes != u && D.mimeTypes[y] && !D.mimeTypes[y].enabledPlugin)) {
                                        E = true;
                                        ax = false;
                                        az = az.replace(/^.*\s+(\S+\s+\S+$)/, '$1');
                                        ay[0] = parseInt(az.replace(/^(.*)\..*$/, '$1'), 10);
                                        ay[1] = parseInt(az.replace(/^.*\.(.*)\s.*$/, '$1'), 10);
                                        ay[2] = /[a-zA-Z]/.test(az) ? parseInt(az.replace(/^.*[a-zA-Z]+(.*)$/, '$1'), 10) : 0;
                                    }
                                } else if (typeof B.ActiveXObject != u)
                                    try {
                                        var aA = new ActiveXObject(x);
                                        if (aA) {
                                            az = aA.GetVariable('$version');
                                            if (az) {
                                                ax = true;
                                                az = az.split(' ')[1].split(',');
                                                ay = [parseInt(az[0], 10), parseInt(az[1], 10), parseInt(az[2], 10)];
                                            }
                                        }
                                    } catch (aB) {
                                    }
                                return {
                                    w3: ar,
                                    pv: ay,
                                    wk: aw,
                                    ie: ax,
                                    win: au,
                                    mac: av
                                };
                            })(),
                            T = (function() {
                                if (!S.w3)
                                    return;
                                if (typeof C.readyState != u && C.readyState == 'complete' || typeof C.readyState == u && (C.getElementsByTagName('body')[0] || C.body))
                                    U();
                                if (!N) {
                                    if (typeof C.addEventListener != u)
                                        C.addEventListener('DOMContentLoaded', U, false);
                                    if (S.ie && S.win) {
                                        C.attachEvent(A, function() {
                                            if (C.readyState == 'complete') {
                                                C.detachEvent(A, arguments.callee);
                                                U();
                                            }
                                        });
                                        if (B == top)
                                            (function() {
                                                if (N)
                                                    return;
                                                try {
                                                    C.documentElement.doScroll('left');
                                                } catch (ar) {
                                                    setTimeout(arguments.callee, 0);
                                                    return;
                                                }
                                                U();
                                            })();
                                    }
                                    if (S.wk)
                                        (function() {
                                            if (N)
                                                return;
                                            if (!/loaded|complete/.test(C.readyState)) {
                                                setTimeout(arguments.callee, 0);
                                                return;
                                            }
                                            U();
                                        })();
                                    W(U);
                                }
                            })();
                    setTimeout(function() {
                        U();
                    }, 100);

                    function U() {
                        if (N)
                            return;
                        try {
                            var ar = C.getElementsByTagName('body')[0].appendChild(dX('span'));
                            ar.parentNode.removeChild(ar);
                        } catch (au) {
                            return;
                        }
                        N = true;
                        var as = F.length;
                        for (var at = 0; at < as; at++)
                            F[at]();
                    }
                    ;

                    function V(ar) {
                        if (N)
                            ar();
                        else
                            F[F.length] = ar;
                    }
                    ;

                    function W(ar) {
                        if (typeof B.addEventListener != u)
                            B.addEventListener('load', ar, false);
                        else if (typeof C.addEventListener != u)
                            C.addEventListener('load', ar, false);
                        else if (typeof B.attachEvent != u)
                            gs(B, 'onload', ar);
                        else if (typeof B.onload == 'function') {
                            var as = B.onload;
                            B.onload = function() {
                                as();
                                ar();
                            };
                        } else
                            B.onload = ar;
                    }
                    ;

                    function X() {
                        if (E)
                            Y();
                        else
                            Z();
                    }
                    ;

                    function Y() {
                        var ar = C.getElementsByTagName('body')[0],
                                as = dX(v);
                        as.setAttribute('type', y);
                        var at = ar.appendChild(as);
                        if (at) {
                            var au = 0;
                            (function() {
                                var av;
                                try {
                                    av = typeof at.GetVariable != u;
                                } catch (ax) {
                                    av = false;
                                }
                                if (av) {
                                    var aw = at.GetVariable('$version');
                                    if (aw) {
                                        aw = aw.split(' ')[1].split(',');
                                        S.pv = [parseInt(aw[0], 10), parseInt(aw[1], 10), parseInt(aw[2], 10)];
                                    }
                                } else if (au < 10) {
                                    au++;
                                    setTimeout(arguments.callee, 10);
                                    return;
                                }
                                ar.removeChild(as);
                                at = null;
                                Z();
                            })();
                        } else
                            Z();
                    }
                    ;

                    function Z() {
                        var ar = G.length;
                        if (ar > 0)
                            for (var as = 0; as < ar; as++) {
                                var at = G[as].id,
                                        au = G[as].callbackFn,
                                        av = {
                                            success: false,
                                            id: at
                                        };
                                if (S.pv[0] > 0) {
                                    var aw = gB(at);
                                    if (aw)
                                        if (am(G[as].swfVersion) && !(S.wk && S.wk < 312)) {
                                            gR(at, true);
                                            if (au) {
                                                av.success = true;
                                                av.ref = aa(at);
                                                au(av);
                                            }
                                        } else if (G[as].ln && aT()) {
                                            var ax = {};
                                            ax.data = G[as].ln;
                                            ax.width = aw.getAttribute('width') || '0';
                                            ax.height = aw.getAttribute('height') || '0';
                                            if (aw.getAttribute('class'))
                                                ax.styleclass = aw.getAttribute('class');
                                            if (aw.getAttribute('align'))
                                                ax.align = aw.getAttribute('align');
                                            var ay = {}, az = aw.getElementsByTagName('param'),
                                                    aA = az.length;
                                            for (var aB = 0; aB < aA; aB++) {
                                                if (az[aB].getAttribute('name').toLowerCase() != 'movie')
                                                    ay[az[aB].getAttribute('name')] = az[aB].getAttribute('value');
                                            }
                                            bm(ax, ay, at, au);
                                        } else {
                                            bW(aw);
                                            if (au)
                                                au(av);
                                        }
                                } else {
                                    gR(at, true);
                                    if (au) {
                                        var aC = aa(at);
                                        if (aC && typeof aC.SetVariable != u) {
                                            av.success = true;
                                            av.ref = aC;
                                        }
                                        au(av);
                                    }
                                }
                            }
                    }
                    ;

                    function aa(ar) {
                        var as = null,
                                at = gB(ar);
                        if (at && at.nodeName == 'OBJECT')
                            if (typeof at.SetVariable != u)
                                as = at;
                            else {
                                var au = at.getElementsByTagName(v)[0];
                                if (au)
                                    as = au;
                            }
                        return as;
                    }
                    ;

                    function aT() {
                        return !O && am('6.0.65') && (S.win || S.mac) && !(S.wk && S.wk < 312);
                    }
                    ;

                    function bm(ar, as, at, au) {
                        O = true;
                        L = au || null;
                        M = {
                            success: false,
                            id: at
                        };
                        var av = gB(at);
                        if (av) {
                            if (av.nodeName == 'OBJECT') {
                                J = eS(av);
                                K = null;
                            } else {
                                J = av;
                                K = at;
                            }
                            ar.id = z;
                            if (typeof ar.width == u || !/%$/.test(ar.width) && parseInt(ar.width, 10) < 310)
                                ar.width = '310';
                            if (typeof ar.height == u || !/%$/.test(ar.height) && parseInt(ar.height, 10) < 137)
                                ar.height = '137';
                            C.title = C.title.slice(0, 47) + ' - Flash Player Installation';
                            var aw = S.ie && S.win ? 'ActiveX' : 'PlugIn',
                                    ax = 'MMredirectURL=' + B.location.toString().replace(/&/g, '%26') + '&MMplayerType=' + aw + '&MMdoctitle=' + C.title;
                            if (typeof as.flashvars != u)
                                as.flashvars += '&' + ax;
                            else
                                as.flashvars = ax;
                            if (S.ie && S.win && av.readyState != 4) {
                                var ay = dX('div');
                                at += 'SWFObjectNew';
                                ay.setAttribute('id', at);
                                av.parentNode.insertBefore(ay, av);
                                av.style.display = 'none';
                                (function() {
                                    if (av.readyState == 4)
                                        av.parentNode.removeChild(av);
                                    else
                                        setTimeout(arguments.callee, 10);
                                })();
                            }
                            fv(ar, as, at);
                        }
                    }
                    ;

                    function bW(ar) {
                        if (S.ie && S.win && ar.readyState != 4) {
                            var as = dX('div');
                            ar.parentNode.insertBefore(as, ar);
                            as.parentNode.replaceChild(eS(ar), as);
                            ar.style.display = 'none';
                            (function() {
                                if (ar.readyState == 4)
                                    ar.parentNode.removeChild(ar);
                                else
                                    setTimeout(arguments.callee, 10);
                            })();
                        } else
                            ar.parentNode.replaceChild(eS(ar), ar);
                    }
                    ;

                    function eS(ar) {
                        var as = dX('div');
                        if (S.win && S.ie)
                            as.innerHTML = ar.innerHTML;
                        else {
                            var at = ar.getElementsByTagName(v)[0];
                            if (at) {
                                var au = at.childNodes;
                                if (au) {
                                    var av = au.length;
                                    for (var aw = 0; aw < av; aw++) {
                                        if (!(au[aw].nodeType == 1 && au[aw].nodeName == 'PARAM') && !(au[aw].nodeType == 8))
                                            as.appendChild(au[aw].cloneNode(true));
                                    }
                                }
                            }
                        }
                        return as;
                    }
                    ;

                    function fv(ar, as, at) {
                        var au, av = gB(at);
                        if (S.wk && S.wk < 312)
                            return au;
                        if (av) {
                            if (typeof ar.id == u)
                                ar.id = at;
                            if (S.ie && S.win) {
                                var aw = '';
                                for (var ax in ar) {
                                    if (ar[ax] != Object.prototype[ax])
                                        if (ax.toLowerCase() == 'data')
                                            as.movie = ar[ax];
                                        else if (ax.toLowerCase() == 'styleclass')
                                            aw += ' class="' + ar[ax] + '"';
                                        else if (ax.toLowerCase() != 'classid')
                                            aw += ' ' + ax + '="' + ar[ax] + '"';
                                }
                                var ay = '';
                                for (var az in as) {
                                    if (as[az] != Object.prototype[az])
                                        ay += '<param name="' + az + '" value="' + as[az] + '" />';
                                }
                                av.outerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"' + aw + '>' + ay + '</object>';
                                H[H.length] = ar.id;
                                au = gB(ar.id);
                            } else {
                                var aA = dX(v);
                                aA.setAttribute('type', y);
                                for (var aB in ar) {
                                    if (ar[aB] != Object.prototype[aB])
                                        if (aB.toLowerCase() == 'styleclass')
                                            aA.setAttribute('class', ar[aB]);
                                        else if (aB.toLowerCase() != 'classid')
                                            aA.setAttribute(aB, ar[aB]);
                                }
                                for (var aC in as) {
                                    if (as[aC] != Object.prototype[aC] && aC.toLowerCase() != 'movie')
                                        aP(aA, aC, as[aC]);
                                }
                                av.parentNode.replaceChild(aA, av);
                                au = aA;
                            }
                        }
                        return au;
                    }
                    ;

                    function aP(ar, as, at) {
                        var au = dX('param');
                        au.setAttribute('name', as);
                        au.setAttribute('value', at);
                        ar.appendChild(au);
                    }
                    ;

                    function bV(ar) {
                        var as = gB(ar);
                        if (as && as.nodeName == 'OBJECT')
                            if (S.ie && S.win) {
                                as.style.display = 'none';
                                (function() {
                                    if (as.readyState == 4)
                                        eN(ar);
                                    else
                                        setTimeout(arguments.callee, 10);
                                })();
                            } else
                                as.parentNode.removeChild(as);
                    }
                    ;

                    function eN(ar) {
                        var as = gB(ar);
                        if (as) {
                            for (var at in as) {
                                if (typeof as[at] == 'function')
                                    as[at] = null;
                            }
                            as.parentNode.removeChild(as);
                        }
                    }
                    ;

                    function gB(ar) {
                        var as = null;
                        try {
                            as = C.getElementById(ar);
                        } catch (at) {
                        }
                        return as;
                    }
                    ;

                    function dX(ar) {
                        return C.createElement(ar);
                    }
                    ;

                    function gs(ar, as, at) {
                        ar.attachEvent(as, at);
                        I[I.length] = [ar, as, at];
                    }
                    ;

                    function am(ar) {
                        var as = S.pv,
                                at = ar.split('.');
                        at[0] = parseInt(at[0], 10);
                        at[1] = parseInt(at[1], 10) || 0;
                        at[2] = parseInt(at[2], 10) || 0;
                        return as[0] > at[0] || as[0] == at[0] && as[1] > at[1] || as[0] == at[0] && as[1] == at[1] && as[2] >= at[2] ? true : false;
                    }
                    ;

                    function gP(ar, as, at, au) {
                        if (S.ie && S.mac)
                            return;
                        var av = C.getElementsByTagName('head')[0];
                        if (!av)
                            return;
                        var aw = at && typeof at == 'string' ? at : 'screen';
                        if (au) {
                            P = null;
                            Q = null;
                        }
                        if (!P || Q != aw) {
                            var ax = dX('style');
                            ax.setAttribute('type', 'text/css');
                            ax.setAttribute('media', aw);
                            P = av.appendChild(ax);
                            if (S.ie && S.win && typeof C.styleSheets != u && C.styleSheets.length > 0)
                                P = C.styleSheets[C.styleSheets.length - 1];
                            Q = aw;
                        }
                        if (S.ie && S.win) {
                            if (P && typeof P.addRule == v)
                                P.addRule(ar, as);
                        } else if (P && typeof C.createTextNode != u)
                            P.appendChild(C.createTextNode(ar + ' {' + as + '}'));
                    }
                    ;

                    function gR(ar, as) {
                        if (!R)
                            return;
                        var at = as ? 'visible' : 'hidden';
                        if (N && gB(ar))
                            gB(ar).style.visibility = at;
                        else
                            gP('#' + ar, 'visibility:' + at);
                    }
                    ;

                    function pw(ar) {
                        var as = /[\\\"<>\.;]/,
                                at = as.exec(ar) != null;
                        return at && typeof encodeURIComponent != u ? encodeURIComponent(ar) : ar;
                    }
                    ;
                    var aq = (function() {
                        if (S.ie && S.win)
                            s.attachEvent('onunload', function() {
                                var ar = I.length;
                                for (var as = 0; as < ar; as++)
                                    I[as][0].detachEvent(I[as][1], I[as][2]);
                                var at = H.length;
                                for (var au = 0; au < at; au++)
                                    bV(H[au]);
                                for (var av in S)
                                    S[av] = null;
                                S = null;
                                if (typeof swfobject != 'undefined') {
                                    for (var aw in swfobject)
                                        swfobject[aw] = null;
                                    swfobject = null;
                                }
                            });
                    })();
                    return {
                        gH: function(ar, as, at, au) {
                            if (S.w3 && ar && as) {
                                var av = {};
                                av.id = ar;
                                av.swfVersion = as;
                                av.ln = at;
                                av.callbackFn = au;
                                G[G.length] = av;
                                gR(ar, false);
                            } else if (au)
                                au({
                                    success: false,
                                    id: ar
                                });
                        },
                        lp: function(ar) {
                            if (S.w3)
                                return aa(ar);
                        },
                        embedSWF: function(ar, as, at, au, av, aw, ax, ay, az, aA) {
                            var aB = {
                                success: false,
                                id: as
                            };
                            if (S.w3 && !(S.wk && S.wk < 312) && ar && as && at && au && av) {
                                gR(as, false);
                                V(function() {
                                    at += '';
                                    au += '';
                                    var aC = {};
                                    if (az && typeof az === v)
                                        for (var aD in az)
                                            aC[aD] = az[aD];
                                    aC.data = ar;
                                    aC.width = at;
                                    aC.height = au;
                                    var aE = {};
                                    if (ay && typeof ay === v)
                                        for (var aF in ay)
                                            aE[aF] = ay[aF];
                                    if (ax && typeof ax === v)
                                        for (var aG in ax) {
                                            if (typeof aE.flashvars != u)
                                                aE.flashvars += '&' + aG + '=' + ax[aG];
                                            else
                                                aE.flashvars = aG + '=' + ax[aG];
                                        }
                                    if (am(av)) {
                                        var aH = fv(aC, aE, as);
                                        if (aC.id == as)
                                            gR(as, true);
                                        aB.success = true;
                                        aB.ref = aH;
                                    } else if (aw && aT()) {
                                        aC.data = aw;
                                        bm(aC, aE, as, aA);
                                        return;
                                    } else
                                        gR(as, true);
                                    if (aA)
                                        aA(aB);
                                });
                            } else if (aA)
                                aA(aB);
                        },
                        switchOffAutoHideShow: function() {
                            R = false;
                        },
                        ua: S,
                        kL: function() {
                            return {
                                major: S.pv[0],
                                minor: S.pv[1],
                                release: S.pv[2]
                            };
                        },
                        kf: am,
                        iV: function(ar, as, at) {
                            if (S.w3)
                                return fv(ar, as, at);
                            else
                                return undefined;
                        },
                        jS: function(ar, as, at, au) {
                            if (S.w3 && aT())
                                bm(ar, as, at, au);
                        },
                        jv: function(ar) {
                            if (S.w3)
                                bV(ar);
                        },
                        ik: function(ar, as, at, au) {
                            if (S.w3)
                                gP(ar, as, at, au);
                        },
                        cz: V,
                        jC: W,
                        kY: function(ar) {
                            var as = C.location.search || C.location.hash;
                            if (as) {
                                if (/\?/.test(as))
                                    as = as.split('?')[1];
                                if (ar == null)
                                    return pw(as);
                                var at = as.split('&');
                                for (var au = 0; au < at.length; au++) {
                                    if (at[au].substring(0, at[au].indexOf('=')) == ar)
                                        return pw(at[au].substring(at[au].indexOf('=') + 1));
                                }
                            }
                            return '';
                        },
                        lq: function() {
                            if (O) {
                                var ar = gB(z);
                                if (ar && J) {
                                    ar.parentNode.replaceChild(J, ar);
                                    if (K) {
                                        gR(K, true);
                                        if (S.ie && S.win)
                                            J.style.display = 'block';
                                    }
                                    if (L)
                                        L(M);
                                }
                                O = false;
                            }
                        }
                    };
                }
                ;
                CKFinder.addPlugin('flashupload', {
                    readOnly: false,
                    appReady: function(s) {
                        if (s.config.connectorLanguage == 'asp' && !CKFinder.env.ie)
                            return;
                        var t = s.document,
                                u = t.defaultView || t.parentWindow,
                                v = r(u, t);
                        if (!v.kf('10.2.0'))
                            return;
                        setTimeout(function() {
                            s.replaceUploadForm('<iframe src="' + CKFinder.getPluginPath('flashupload') + 'Uploader.html' + '" style="width: 100%; height: 98%;" frameBorder="0"></iframe>', function() {
                                s.resizeFormPanel(100);
                                u.api = s;
                                u.create_swfobject = r;
                                u.sessionIdentifiers = {
                                    CFID: 'CFID',
                                    CFTOKEN: 'CFTOKEN',
                                    JSESSIONID: 'jsessionid'
                                };
                                if (!CKFinder.env.ie && !u.flash_cookies)
                                    s.connector.sendCommandPost('LoadCookies', null, null, function(w) {
                                        if (w.checkError())
                                            return false;
                                        var x = w.selectSingleNode('Connector/Cookies');
                                        if (x) {
                                            var y = x.attributes.getNamedItem('sessionCookieName'),
                                                    z = x.attributes.getNamedItem('sessionParameterName');
                                            if (y && y.value && z && z.value)
                                                u.sessionIdentifiers[y.value] = z.value;
                                        }
                                        var A = w.selectNodes('Connector/Cookies/Cookie');
                                        if (A && A.length) {
                                            u.flash_cookies = {};
                                            for (var B = 0; B < A.length; B++) {
                                                var C = A[B].attributes.getNamedItem('value').value,
                                                        D = A[B].attributes.getNamedItem('name').value;
                                                u.flash_cookies[D] = C;
                                            }
                                        }
                                    });
                            }, false, 12);
                        }, 100);
                    }
                });
            })();
            (function(r, s, t) {
                'use strict';
                var u = /\.([^\.]+)\s*$/,
                        v = /^(jpg|jpeg|gif|png|bmp)$/i,
                        w = /\|/,
                        x = /(\{\{([a-z_]+)\}\})/g,
                        y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T = function() {
                            return new Date().getTime();
                        }, U, V, W, X, Y, Z, aa, aT, bm, bW, eS, fv, aP = 500,
                        bV = false,
                        eN = 'ckf_plugin_html5upload_' + T(),
                        gB = eN + '_fallbackAsyncArrayTraverse',
                        dX = eN + '_fallbackShouldFallback',
                        gs = eN + '_fallbackOnFileBlobReady',
                        am = eN + '_fallbackOnXMLHttpRequestReady',
                        gP = "CKFinder._['" + eN + "']['{{application_name}}']",
                        gR = "var _files = ((('undefined' === typeof files) ? (this.files || (event.dataTransfer && event.dataTransfer.files)) : files) || []);setTimeout(function () {" + gP + "['" + gB + "'](_files, function (file, index, files) {" + 'var formData = new FormData(),' + 'uploadBlob,' + 'xhr = new XMLHttpRequest();' + 'if (file && ' + gP + "['" + dX + "'](file)) {" + "formData.append('upload', file);" + 'uploadBlob = ' + gP + "['" + gs + "'](file, formData);" + gP + "['" + am + "'](file, uploadBlob, xhr, xhr.send.bind(xhr, formData), xhr.abort.bind(xhr));" + '} else {' + 'return false;' + '}' + '});' + '}, ' + aP + ');',
                        pw = '<div id="ckf_upload_form" ondrop="' + gR + '">' + '<div class="ckf_upload_info" id="ckf_globalUploads">' + '<div class="ckf_progress_wrapper"><div class="ckf_progress_info">' + '<span></span>' + '<span></span>' + '<div class="ckf_progress_bar_container"><div></div></div>' + '<span class="ckf_status"></span><span class="ckf_speed"></span>' + '</div></div>' + '<div class="ckf_uploadButtons">' + '<input type="file" {{input_multiple}} id="ckf_fileInput" onchange="' + gR + '">' + '<a class="cke_dialog_ui_button" href="javascript:void(0);"><span class="cke_dialog_ui_button" id="ckf_addFiles">{{lang_upload_add_files}}</span></a><br>' + '<a class="cke_dialog_ui_button cke_dialog_ui_button_ok" href="javascript:void(0);" id="ckf_cancelUpload"><span class="cke_dialog_ui_button">{{lang_close_button}}</span></a>' + '</div>' + '</div>' + '</div>',
                        aq = '<div class="ckf_progress_wrapper"><div class="ckf_progress_info"><span>{{file_name}}</span><span></span><div class="ckf_progress_bar_container"><div></div></div><span class="ckf_status"></span><span class="ckf_speed"></span><div class="ckf_outcome"></div></div></div><div class="ckf_uploadButtons"><a class="cke_dialog_ui_button cke_dialog_ui_button_cancel" name="cancel"><span class="cke_dialog_ui_button">{{lang_cancel_button}}</span></a></div>';
                if (Object.hasOwnProperty('create'))
                    S = Object.create;
                else
                    S = function(ar) {
                        bV = true;
                        return ar;
                    };
                R = function(ar, as, at) {
                    var au = 10,
                            av = 10,
                            aw = 0,
                            ax;
                    at || (at = null);
                    as = as.bind(at);
                    (ax = function() {
                        var ay, az = 0,
                                aA = T();
                        for (; ; ) {
                            ay = ar.item ? ar.item(aw) : ar[aw];
                            if (!ay || false === as(ay, aw, ar))
                                return;
                            aw += 1;
                            az += 1;
                            if (az >= av && T() - aA > au)
                                return setTimeout(ax, au);
                        }
                    })();
                };
                U = function(ar) {
                    return function(as) {
                        var at;
                        for (at in ar) {
                            if (ar.hasOwnProperty(at))
                                as[at] = ar[at];
                        }
                        return as;
                    };
                };
                B = function() {
                    this.uU = [];
                };
                B.prototype.mD = function(ar) {
                    var as = this;
                    if (!(ar instanceof B))
                        throw new Error('Invalid argument: expected xc.');
                    ar.sy().forEach(function(at) {
                        as.ns(at);
                    });
                };
                B.mixin = U(B.prototype);
                B.prototype.ns = function(ar) {
                    if (!(ar instanceof C))
                        throw new Error('Invalid argument: expected tq.');
                    if (this.sL(ar))
                        throw new Error('Logic error: same tq is added twice to the xc');
                    this.uU.push(ar);
                };
                B.prototype.dispatch = function(ar, as) {
                    this.uU.forEach(function(at) {
                        var au = at.tc();
                        if (au.hasOwnProperty(ar))
                            at[au[ar]].apply(at, as);
                    });
                };
                B.prototype.sy = function(ar) {
                    if (!ar)
                        return this.uU.slice(0);
                    return this.uU.filter(function(as) {
                        return as.sV(ar);
                    });
                };
                B.prototype.sL = function(ar) {
                    return -1 !== this.uU.indexOf(ar);
                };
                B.prototype.removeSubscriber = function(ar) {
                    var as = this.uU.indexOf(ar);
                    if (!(ar instanceof C))
                        throw new Error('Invalid argument: expected tq.');
                    if (-1 === as)
                        throw new Error('Logic error: this tq is not registered');
                    this.uU.splice(as, 1);
                };
                C = function() {
                };
                C.prototype.sV = function(ar) {
                    return this.tc().hasOwnProperty(ar);
                };
                C.prototype.tc = function() {
                    throw new Error('This method needs to be overriden in child class.');
                };
                y = function() {
                    C.call(this);
                };
                y.prototype = S(C.prototype);
                y.prototype.tc = function() {
                    var ar = {};
                    ar[O.qM] = 'tF';
                    return ar;
                };
                y.prototype.tF = function(ar, as) {
                    var at = as.targetFolder,
                            au = ar.connector.composeUrl('FileUpload', {
                                response_type: 'txt'
                            }, at.type, at);
                    as.bT.open('POST', au);
                };
                F = function(ar, as, at, au) {
                    var av = this;
                    C.call(av);
                    av.ckFinder = ar;
                    av.application = as;
                    av.ty = at;
                    av.ub = au;
                };
                F.prototype = S(C.prototype);
                I = function(ar) {
                    this.tw(ar);
                };
                I.mixin = U(I.prototype);
                I.prototype.tj = function() {
                    if (!this.so)
                        throw new Error('Form panel widget is not set.');
                    return this.so;
                };
                I.prototype.sX = function() {
                    return !!this.so;
                };
                I.prototype.uV = function(ar) {
                };
                I.prototype.tC = function(ar) {
                };
                I.prototype.tw = function(ar) {
                    var as = this;
                    if (!as.so && ar)
                        as.uV(ar);
                    else if (as.so && ar) {
                        as.tC(as.so);
                        as.uV(ar);
                    } else if (as.so && !ar)
                        as.tC(as.so);
                    as.so = ar;
                };
                A = function(ar, as, at, au) {
                    F.call(this, ar, as, at, au);
                    I.call(this);
                };
                A.prototype = S(F.prototype);
                A.prototype = I.mixin(A.prototype);
                A.prototype.mE = function(ar) {
                    var ax = this;
                    var as = ar.layout.pn(),
                            at = as.getDocument(),
                            au = ax.sS.bind(ax),
                            av = ax.ss.bind(ax),
                            aw = ax.rs.bind(ax);
                    at.on('drop', aw);
                    at.on('dragover', av);
                    as.on('dragover', au);
                    if (!ax.domElementListeners)
                        ax.domElementListeners = [];
                    ax.domElementListeners.push({
                        evt: 'drop',
                        fO: aw,
                        bi: at
                    }, {
                        evt: 'dragover',
                        fO: av,
                        bi: at
                    }, {
                        evt: 'dragover',
                        fO: au,
                        bi: as
                    });
                };
                A.prototype.ss = function(ar) {
                    var as = ar.data,
                            at = as.$.dataTransfer;
                    if (!at)
                        return;
                    at.dropEffect = 'none';
                    try {
                        at.effectAllowed = 'none';
                    } catch (au) {
                    }
                    if (this.ckFinder.env.webkit)
                        as.preventDefault();
                };
                A.prototype.rs = function(ar) {
                    var as = ar.data.$.dataTransfer;
                    if (as && as.files && as.files.length > 0) {
                        this.ub.uG(as.files);
                        ar.data.preventDefault();
                    }
                };
                A.prototype.uV = function(ar) {
                    var av = this;
                    var as = ar.bn().getDocument(),
                            at = av.sS.bind(av),
                            au = as.getById('ckf_upload_form');
                    if (!av.domElementListeners)
                        av.domElementListeners = [];
                    if (av.domElementListeners.length > 0)
                        av.tC(av.so);
                    av.mE(av.application);
                    au.on('dragover', at);
                    av.domElementListeners.push({
                        evt: 'dragover',
                        fO: at,
                        bi: au
                    });
                };
                A.prototype.sS = function(ar) {
                    var as = ar.data,
                            at = as.$.dataTransfer;
                    if (!at)
                        return;
                    if (at.files && at.files.length || at.types && (at.types.contains && at.types.contains('Files') || at.types.indexOf && -1 !== at.types.indexOf('Files'))) {
                        at.dropEffect = 'copy';
                        as.stopPropagation();
                    } else
                        at.dropEffect = 'none';
                    as.preventDefault();
                };
                A.prototype.tC = function(ar) {
                    var as, at;
                    for (as = 0; as < this.domElementListeners.length; as += 1) {
                        at = this.domElementListeners[as];
                        at.bi.removeListener(at.evt, at.fO);
                    }
                    delete this.domElementListeners;
                };
                D = function(ar, as, at, au, av) {
                    F.call(this, ar, as, at, au);
                    this.pJ = av;
                };
                D.shouldFallback = true;
                D.prototype = S(F.prototype);
                D.prototype.lT = function(ar) {
                    var au = this;
                    var as, at;
                    for (as in au.pJ) {
                        if (au.pJ.hasOwnProperty(as))
                            for (at = 0; at < ar.length; at += 1) {
                                if (ar[at] === au.pJ[as])
                                    delete au.pJ[as];
                            }
                    }
                };
                D.prototype.ti = function(ar, as) {
                    if (!D.shouldFallback)
                        return;
                    return new K(ar, new H(as));
                };
                D.prototype.uK = function(ar, as, at, au, av) {
                    var ay = this;
                    if (!D.shouldFallback)
                        return;
                    var aw, ax;
                    if (ay.ub.sX())
                        aw = ay.ub.tj();
                    else {
                        av();
                        return;
                    }
                    ax = new z(ay.application, ay.application.aV, as, au, av);
                    ax.ns(ay.ty);
                    ax.nv(at);
                    as.ns(ax);
                    ay.ub.expectedFiles -= 1;
                    ay.ub.tL(ay.application, ax);
                };
                D.prototype.tS = function(ar, as, at, au, av, aw) {
                    var ay = this;
                    var ax = {};
                    ax[at] = R;
                    ax[au] = ay.shouldFallback.bind(ay);
                    ax[av] = ay.ti.bind(ay);
                    ax[aw] = ay.uK.bind(ay);
                    if (!ar.CKFinder.hasOwnProperty('_'))
                        ar.CKFinder._ = {};
                    ar.CKFinder._[as] = {};
                    ar.CKFinder._[as][ay.application.name] = ax;
                };
                D.prototype.shouldFallback = function(ar, as) {
                    return !this.ub.shouldStopProcessing && D.shouldFallback;
                };
                E = function() {
                    B.call(this);
                };
                E.prototype = S(B.prototype);
                E.qQ = 'xhr.header';
                E.prototype.tn = function(ar, as) {
                    throw new Error('This method needs to be overriden in child class.');
                };
                G = function(ar) {
                    E.call(this);
                    this.file = ar;
                };
                G.prototype = S(E.prototype);
                G.prototype.tn = function(ar, as) {
                    var at = new FormData();
                    at.append('upload', this.file);
                    as(at);
                };
                H = function(ar) {
                    E.call(this);
                    this.formData = ar;
                };
                H.prototype = S(E.prototype);
                H.prototype.tn = function(ar, as) {
                    as(this.formData);
                };
                J = function(ar, as, at, au, av) {
                    F.call(this, ar, as, at, au);
                    this.qJ = av;
                };
                J.prototype = S(F.prototype);
                J.prototype.tc = function() {
                    var ar = {};
                    ar[L.qN] = 'onFileInputChange';
                    return ar;
                };
                J.prototype.onFileInputChange = function(ar, as) {
                    if (this.ub.uG(as))
                        this.qJ.lT(as);
                };
                K = function(ar, as) {
                    this.sz = as;
                    this.file = ar;
                };
                K.prototype = S(B.prototype);
                K.prototype.mD = function(ar) {
                    return this.sz.mD(ar);
                };
                K.prototype.ns = function(ar) {
                    return this.sz.ns(ar);
                };
                K.prototype.dispatch = function(ar, as) {
                    return this.sz.dispatch(ar, as);
                };
                K.prototype.bZ = function() {
                    return this.file;
                };
                K.prototype.wv = function() {
                    var ar = '',
                            as = this.getFileName();
                    if (!u.test(as))
                        return ar;
                    ar = as.match(u);
                    return ar[1].toLowerCase();
                };
                K.prototype.getFileName = function() {
                    return this.file.name;
                };
                K.prototype.getFileSize = function() {
                    return this.file.size;
                };
                K.prototype.sy = function(ar) {
                    return this.sz.sy(ar);
                };
                K.prototype.tn = function(ar) {
                    this.sz.tn(this.file, ar);
                };
                M = function() {
                };
                M.prototype = S(C.prototype);
                M.pH = 'abort';
                M.rj = 'error';
                M.qk = 'load';
                M.rc = 'progress';
                M.prototype.tc = function() {
                    var ar = {};
                    ar[M.pH] = 'onAbort';
                    ar[M.rj] = 'onError';
                    ar[M.qk] = 'onLoad';
                    ar[M.rc] = 'onProgress';
                    return ar;
                };
                M.prototype.onAbort = function(ar) {
                };
                M.prototype.onError = function(ar, as) {
                };
                M.prototype.onLoad = function(ar) {
                };
                M.prototype.onProgress = function(ar, as, at, au) {
                };
                N = function(ar) {
                    var as = this;
                    B.call(as);
                    M.call(as);
                    as.application = ar;
                    as.tM = [];
                };
                N.prototype = S(M.prototype);
                N.prototype = B.mixin(N.prototype);
                N.prototype.mC = function() {
                    var ar = this.tM.concat();
                    this.tM = [];
                    R(ar, function(as, at, au) {
                        if (as && as.sY())
                            as.lN();
                    });
                };
                N.prototype.mU = function(ar) {
                    this.tM.push(ar);
                };
                N.prototype.nU = function(ar) {
                    var as = this.tM.indexOf(ar);
                    if (-1 === as)
                        throw new Error('Given upload supervisor is not attached.');
                    this.tM.splice(as, 1);
                };
                N.prototype.tc = function() {
                    var ar = M.prototype.tc.call(this);
                    ar[P.pN] = 'uc';
                    ar[O.qM] = 'tF';
                    return ar;
                };
                N.prototype.sj = function(ar) {
                    var as;
                    for (as = 0; as < this.tM.length; as += 1) {
                        if (ar === this.tM[as].uploadBlob.bZ())
                            return true;
                    }
                    return false;
                };
                N.prototype.sB = function(ar) {
                    return~this.tM.indexOf(ar);
                };
                N.prototype.tF = function(ar, as) {
                    this.mU(as);
                };
                N.prototype.uc = function(ar) {
                    if (this.sB(ar))
                        this.nU(ar);
                };
                L = function(ar, as, at) {
                    var au = this;
                    B.call(au);
                    I.call(au);
                    M.call(au);
                    au.application = ar;
                    au.attachedUploadViewsNumber = 0;
                    au.wU = [];
                    au.lastRefresh = 0;
                    au.sa = 0;
                    au.sO = 0;
                    au.tI = 0;
                    au.totalFiles = 0;
                    au.ty = as;
                    au.ub = at;
                    au.tM = [];
                };
                L.prototype = S(M.prototype);
                L.prototype = B.mixin(L.prototype);
                L.prototype = I.mixin(L.prototype);
                L.prototype.mU = N.prototype.mU;
                L.prototype.nU = N.prototype.nU;
                L.prototype.sB = N.prototype.sB;
                L.prototype.tC = A.prototype.tC;
                L.qN = 'event.file.input.change';
                L.ue = 300;
                L.prototype.mC = function() {
                    var as = this;
                    var ar;
                    for (ar = 0; ar < as.tM.length; ar += 1)
                        as.tM[ar].removeSubscriber(as);
                    as.ty.mC();
                    as.ub.or();
                    as.attachedUploadViewsNumber = 0;
                    as.tM = [];
                    as.ud(as.application);
                    as.ma();
                    as.remove();
                };
                L.prototype.tc = function() {
                    var ar = {};
                    ar[O.qM] = 'tF';
                    ar[P.pN] = 'uc';
                    ar[Q.EVENT_DOM_ATTACHED] = 'onUploadViewDomAttached';
                    ar[Q.EVENT_DOM_REMOVED] = 'onUploadViewDomRemoved';
                    ar[Q.pM] = 'onFolderRefreshRequest';
                    return ar;
                };
                L.prototype.onFileInputChange = function(ar) {
                    var as = ar.jN.$,
                            at = as.files;
                    if (at.length < 1)
                        return;
                    this.dispatch(L.qN, [as, at]);
                };
                L.prototype.onFolderRefreshRequest = function(ar, as) {
                    this.wU.push({
                        folder: ar,
                        mw: as
                    });
                };
                L.prototype.uV = function(ar) {
                    var aA = this;
                    var as = ar.bn().getDocument(),
                            at = as.getById('ckf_addFiles'),
                            au = as.getById('ckf_cancelUpload'),
                            av = as.getById('ckf_fileInput'),
                            aw = as.getById('ckf_globalUploads'),
                            ax, ay = aA.mC.bind(aA),
                            az = aA.onFileInputChange.bind(aA);
                    aw = aw.getChild([0, 0]);
                    aA.domElement = {
                        addFilesButton: at,
                        cancelButton: au,
                        countSpan: aw.getChild(0),
                        fileInput: av,
                        ni: aw.getChild([2, 0]),
                        np: aw.getChild(4),
                        mz: aw.getChild(3),
                        totalSizeSpan: aw.getChild(1)
                    };
                    ax = aA.onDomElementAddFilesClickListener.bind(aA);
                    at.on('click', ax);
                    au.on('click', ay);
                    av.on('change', az);
                    if (!aA.domElementListeners)
                        aA.domElementListeners = [];
                    aA.domElementListeners.push({
                        evt: 'click',
                        fO: ax,
                        bi: at
                    }, {
                        evt: 'click',
                        fO: ay,
                        bi: au
                    }, {
                        evt: 'change',
                        fO: az,
                        bi: av
                    });
                    if (aA.shouldBeClickedAutomatically) {
                        aA.shouldBeClickedAutomatically = false;
                        ax();
                    }
                };
                L.prototype.onDomElementAddFilesClickListener = function(ar) {
                    this.domElement.fileInput.$.click();
                };
                L.prototype.onUploadPanelUploadStartClick = function(ar, as, at) {
                    this.shouldBeClickedAutomatically = true;
                    at(ar);
                };
                L.prototype.uH = function(ar) {
                    this.domElement.cancelButton.getFirst().setHtml(ar.lang.UploadBtnCancel);
                };
                L.prototype.ud = function(ar) {
                    var as = this;
                    as.domElement.cancelButton.getFirst().setHtml(ar.lang.CloseBtn);
                    as.sa = 0;
                    as.sO = 0;
                    as.tI = 0;
                    as.totalFiles = 0;
                };
                L.prototype.onUploadViewDomAttached = function(ar) {
                    this.attachedUploadViewsNumber += 1;
                };
                L.prototype.onUploadViewDomRemoved = function(ar) {
                    var as = this;
                    as.attachedUploadViewsNumber -= 1;
                    if (as.ub.expectedFiles < 1 && as.attachedUploadViewsNumber < 1) {
                        as.attachedUploadViewsNumber = 0;
                        as.ub.expectedFiles = 0;
                        as.remove();
                    }
                };
                L.prototype.tF = function(ar, as) {
                    var aw = this;
                    var at = as.uploadBlob.bZ(),
                            au = aw.tj(),
                            av = new Q(ar, as, at);
                    as.ns(aw);
                    as.ns(av);
                    av.ns(aw);
                    av.tw(au);
                    aw.mU(as);
                    aw.tI += at.size;
                    aw.to(aw.tI);
                    aw.totalFiles += 1;
                    aw.tm(aw.totalFiles);
                    if (1 === aw.totalFiles)
                        aw.uH(ar);
                };
                L.prototype.uc = function(ar) {
                    var au = this;
                    var as = au.ub.expectedFiles,
                            at = ar.uploadBlob.bZ();
                    if (au.sB(ar))
                        au.nU(ar);
                    if (as < 1 && au.tM.length < 1) {
                        au.ma();
                        au.ud(au.application);
                    } else {
                        au.sa += at.size;
                        au.sO += 1;
                    }
                    au.updateUploadProgress(au.sa, au.tI, au.sO, au.totalFiles, as);
                    au.to(au.tI);
                    au.tm(au.totalFiles);
                };
                L.prototype.ma = function() {
                    var au = this;
                    var ar, as, at = au.application.aV;
                    for (ar = 0; ar < au.wU.length; ar += 1) {
                        if (au.wU[ar].folder === at) {
                            as = au.wU[ar];
                            break;
                        }
                    }
                    au.wU = [];
                    if (as)
                        au.application.oW('requestShowFolderFiles', as);
                };
                L.prototype.remove = function() {
                    this.tj().oW('requestUnloadForm');
                };
                L.prototype.setUploadCommand = function(ar, as) {
                    var at, au, av, aw;
                    if (!as.pW || as.pW.length < 1)
                        return;
                    if (!this.domElementListeners)
                        this.domElementListeners = [];
                    av = function(ax, ay) {
                        this.onUploadPanelUploadStartClick(ay, as, ax);
                    };
                    aw = as.pW;
                    for (au = 0; au < aw.length; au += 1) {
                        if (aw[au].click) {
                            at = aw[au].click;
                            aw[au].click = av.bind(this, at);
                        }
                    }
                };
                L.prototype.tD = function(ar, as) {
                    this.updateLoadedPercentage(ar, as);
                };
                L.prototype.updateLoadedPercentage = function(ar, as, at) {
                    var au;
                    if (as > 0)
                        au = Math.round(ar / as * 100);
                    else
                        au = 0;
                    if (au < 0)
                        au = 0;
                    if (au > 100 || isNaN(au))
                        au = 100;
                    this.domElement.ni.setStyle('width', au + '%');
                    at = at ? ' - ' + at.trim() : '';
                    this.updateStatusText(this.application.lang.UploadUploaded.replace('!n', au) + at);
                };
                L.prototype.nR = function(ar, as) {
                    var at;
                    if (as < 1)
                        return;
                    at = ar / 1024 / as;
                    this.domElement.np.setText(k.formatSpeed(at, this.application.lang));
                };
                L.prototype.updateStatusText = function(ar) {
                    this.domElement.mz.setText(ar);
                };
                L.prototype.to = function(ar) {
                    this.domElement.totalSizeSpan.setText(this.application.lang.UploadTotalSize + ' ' + k.formatSize(ar / 1024, this.application.lang));
                };
                L.prototype.tm = function(ar) {
                    this.domElement.countSpan.setText(this.application.lang.UploadTotalFiles + ' ' + ar + ' ');
                };
                L.prototype.updateUploadProgress = function(ar, as, at, au, av) {
                    var aw = ar / as,
                            ax = 1,
                            ay = at / (au + av),
                            az = 3,
                            aA;
                    aA = CKFinder.tools.formatSize(ar / 1024, this.application.lang);
                    this.updateLoadedPercentage(aw * ax + ay * az, ax + az, aA);
                };
                O = function(ar, as) {
                    var at = this;
                    B.call(at);
                    I.call(at);
                    M.call(at);
                    at.application = ar;
                    at.lQ = 10;
                    at.expectedFiles = 0;
                    at.shouldStopProcessing = false;
                    at.tM = [];
                    at.ty = as;
                };
                O.prototype = S(M.prototype);
                O.prototype = B.mixin(O.prototype);
                O.prototype = I.mixin(O.prototype);
                O.qM = 'upload.supervisor.ready';
                O.prototype.or = function() {
                    this.expectedFiles = 0;
                    this.shouldStopProcessing = true;
                    this.tM = [];
                };
                O.prototype.nZ = function() {
                    return this.tM.shift();
                };
                O.prototype.qg = function(ar) {
                    if (!this.sj(ar.file))
                        this.tM.push(ar);
                };
                O.prototype.tc = function() {
                    var ar = {};
                    ar[P.pU] = 'tH';
                    ar[P.pN] = 'uc';
                    return ar;
                };
                O.prototype.getUploadCommand = function() {
                    if (!this.uploadCommand)
                        throw new Error('Upload command is not set.');
                    return this.uploadCommand;
                };
                O.prototype.sj = function(ar) {
                    var as;
                    for (as = 0; as < this.tM.length; as += 1) {
                        if (ar === this.tM[as].uploadBlob.bZ())
                            return true;
                    }
                    return false;
                };
                O.prototype.isEmpty = function() {
                    return this.tM.length < 1;
                };
                O.prototype.tH = function() {
                    this.tx();
                };
                O.prototype.uc = function() {
                    this.lQ += 1;
                    this.tx();
                };
                O.prototype.uG = function(ar) {
                    var as = 100,
                            at, au, av = this.sX(),
                            aw, ax = this,
                            ay = this.getUploadCommand(),
                            az = this.application.aV;
                    if (!az)
                        return false;
                    this.expectedFiles += ar.length;
                    this.shouldStopProcessing = false;
                    if (ay.bu === r.aY)
                        return;
                    if (ar.length < 1)
                        return false;
                    try {
                        au = ar[0];
                        D.shouldFallback = false;
                    } catch (aA) {
                        return false;
                    } finally {
                        if (ay.bu !== r.eV) {
                            av = false;
                            ay.exec(this.application);
                        }
                    }
                    aw = R.bind(null, ar, function(aB, aC, aD) {
                        if (ax.shouldStopProcessing) {
                            ax.expectedFiles = 0;
                            ax.shouldStopProcessing = false;
                            return false;
                        }
                        ax.expectedFiles -= 1;
                        ax.tA(new K(aB, new G(aB)));
                    });
                    if (av) {
                        aw();
                        return true;
                    }
                    at = setInterval(function() {
                        if (!ax.sX())
                            return;
                        clearInterval(at);
                        aw();
                    }, as);
                    return true;
                };
                O.prototype.tA = function(ar) {
                    var au = this;
                    var as, at;
                    if (ar.getFileName().length < 1) {
                        au.tj().oW('failedUploadFile');
                        return;
                    }
                    at = new P(au.application, au.application.aV, ar);
                    at.ns(au.ty);
                    ar.ns(at);
                    as = new XMLHttpRequest();
                    at.nv(as);
                    au.tL(au.application, at);
                };
                O.prototype.tL = function(ar, as) {
                    var at = this;
                    at.dispatch(O.qM, [at.application, as]);
                    as.ns(at);
                    if (at.lQ < 1) {
                        at.qg(as);
                        return;
                    }
                    at.tv(ar, as);
                };
                O.prototype.tx = function() {
                    var ar = this;
                    while (ar.tM.length > 0 && ar.lQ > 0)
                        ar.tv(ar.application, ar.nZ());
                };
                O.prototype.tJ = function(ar) {
                    this.lQ = ar;
                };
                O.prototype.setUploadCommand = function(ar, as) {
                    this.uploadCommand = as;
                };
                O.prototype.tv = function(ar, as) {
                    this.lQ -= 1;
                    as.mW();
                };
                P = function(ar, as, at) {
                    var au = this;
                    B.call(au);
                    M.call(au);
                    au.application = ar;
                    au.isAborted = false;
                    au.sa = 0;
                    au.oS = 0;
                    au.targetFolder = as;
                    au.uploadBlob = at;
                };
                P.prototype = S(M.prototype);
                P.prototype = B.mixin(P.prototype);
                P.pU = 'start';
                P.pN = 'stop';
                P.prototype.lN = function() {
                    if (!this.sY())
                        throw new Error('Upload is not in progress.');
                    this.isAborted = true;
                    this.bT.abort();
                };
                P.prototype.ns = function(ar) {
                    if (!(ar instanceof M))
                        throw new Error('Invalid argument: expected ux.');
                    B.prototype.ns.call(this, ar);
                };
                P.prototype.ta = function(ar) {
                    var as = this.wv(),
                            at = ar.aV,
                            au = at.getResourceType();
                    if (as && !au.isExtensionAllowed(as)) {
                        this.onError(ar.lang.UploadExtIncorrect);
                        return false;
                    }
                    return true;
                };
                P.prototype.wN = function(ar) {
                    var ay = this;
                    var as = ay.wv(),
                            at = ay.getFileSize(),
                            au = parseInt(ar.config.uploadMaxSize, 10),
                            av, aw = ar.aV,
                            ax = aw.getResourceType();
                    av = parseInt(ax.maxSize, 10);
                    if (at === 0) {
                        ay.onError(ar.lang.Errors[202]);
                        return false;
                    }
                    if (au && at > au || av && at > av && (ar.config.uploadCheckImages || !v.test(as))) {
                        ay.onError(ar.lang.Errors[203]);
                        return false;
                    }
                    return true;
                };
                P.prototype.tl = function(ar) {
                    if (!this.ta(ar))
                        return false;
                    if (!this.wN(ar))
                        return false;
                    return true;
                };
                P.prototype.nv = function(ar) {
                    var at = this;
                    var as;
                    if (at.sY())
                        throw new Error('Upload is already started.');
                    ar.addEventListener(M.pH, at.onAbort.bind(at));
                    ar.addEventListener(M.rj, at.onError.bind(at));
                    ar.addEventListener(M.qk, at.onLoad.bind(at));
                    as = ar.upload;
                    if (as)
                        as.addEventListener(M.rc, at.onProgress.bind(at));
                    at.bT = ar;
                    at.isAborted = false;
                };
                P.prototype.tK = function() {
                    return this.oS;
                };
                P.prototype.bZ = function() {
                    return this.uploadBlob.bZ();
                };
                P.prototype.wv = function() {
                    return this.uploadBlob.wv();
                };
                P.prototype.getFileName = function() {
                    return this.uploadBlob.getFileName();
                };
                P.prototype.getFileSize = function() {
                    return this.uploadBlob.getFileSize();
                };
                P.prototype.tc = function() {
                    var ar = M.prototype.tc.call(this);
                    ar['xhr.header'] = 'tO';
                    return ar;
                };
                P.prototype.sY = function() {
                    if (this.isAborted)
                        return false;
                    return !!this.bT;
                };
                P.prototype.onAbort = function(ar) {
                    this.dispatch(M.pH, [this.uploadBlob]);
                    this.onStop();
                };
                P.prototype.onError = function(ar) {
                    var as = this;
                    if (!ar)
                        ar = as.application.lang.UploadUnknError;
                    as.dispatch(M.rj, [as.uploadBlob, ar]);
                    as.onStop();
                };
                P.prototype.tO = function(ar, as) {
                    if (!this.bT)
                        throw new Error('Request is not initialized');
                    this.bT.setRequestHeader(ar, as);
                };
                P.prototype.onLoad = function(ar) {
                    var ax = this;
                    var as, at, au, av = 2,
                            aw;
                    if (200 !== ax.bT.status)
                        return ax.onError();
                    au = ar.target.responseText, aw = au.split(w, av);
                    as = aw[0];
                    at = aw[1];
                    if (!as.length && at)
                        ax.dispatch(M.rj, [ax.uploadBlob, at]);
                    else
                        ax.dispatch(M.qk, [ax.uploadBlob, as, at]);
                    ax.onStop();
                };
                P.prototype.onProgress = function(ar) {
                    var as = this;
                    if (!ar.lengthComputable)
                        return;
                    as.sa = ar.target.kC = ar.loaded;
                    as.dispatch(M.rc, [as, as.uploadBlob, as.sa, as.tK()]);
                };
                P.prototype.onStop = function() {
                    var ar = this;
                    delete ar.bT;
                    ar.isAborted = true;
                    ar.oS = 0;
                    ar.dispatch(P.pN, [ar, ar.uploadBlob]);
                };
                P.prototype.mW = function() {
                    var ar = this,
                            as = this.bT;
                    if (!this.tl(this.application))
                        return false;
                    this.uploadBlob.tn(function(at) {
                        ar.dispatch(P.pU, [ar.uploadBlob]);
                        if (as) {
                            ar.oS = T();
                            try {
                                ar.bT.send(at);
                            } catch (au) {
                                ar.onStop();
                            }
                        } else
                            ar.onStop();
                    });
                };
                z = function(ar, as, at, au, av) {
                    var aw = this;
                    P.call(aw, ar, as, at);
                    aw.isAborted = false;
                    aw.tG = au;
                    aw.uz = av;
                };
                z.prototype = S(P.prototype);
                z.prototype.lN = function() {
                    if (!this.sY())
                        throw new Error('Upload is not in progress.');
                    this.isAborted = true;
                    this.uz();
                };
                z.prototype.mW = function() {
                    var ar = this;
                    if (!ar.tl(ar.application))
                        return false;
                    ar.isAborted = false;
                    ar.oS = T();
                    ar.dispatch(P.pU, [ar.uploadBlob]);
                    try {
                        ar.tG();
                    } catch (as) {
                        try {
                            ar.uz();
                        } catch (as) {
                            throw as;
                        } finally {
                            ar.onStop();
                        }
                    }
                };
                Q = function(ar, as, at) {
                    var au = this;
                    B.call(au);
                    I.call(au);
                    M.call(au);
                    au.application = ar;
                    au.file = at;
                    au.isDomAttached = false;
                    au.isDomRemoved = false;
                    au.shouldBeRemovedOnStop = true;
                    au.targetFolder = as.targetFolder;
                    au.ts = as;
                };
                Q.prototype = S(M.prototype);
                Q.prototype = B.mixin(Q.prototype);
                Q.prototype = I.mixin(Q.prototype);
                Q.prototype.tD = L.prototype.updateLoadedPercentage;
                Q.prototype.nR = L.prototype.nR;
                Q.prototype.updateStatusText = L.prototype.updateStatusText;
                Q.EVENT_DOM_ATTACHED = 'event.dom.attached';
                Q.EVENT_DOM_REMOVED = 'event.dom.removed';
                Q.pM = 'event.folder.refresh.request';
                Q.prototype.tc = function() {
                    var ar = M.prototype.tc.call(this);
                    ar[P.pN] = 'onStop';
                    return ar;
                };
                Q.prototype.onAbort = function(ar) {
                    var as = this;
                    if (!as.ts)
                        return;
                    if (as.ts.sY()) {
                        as.ts.lN();
                        as.ts.onStop();
                    }
                    as.onStop();
                };
                Q.prototype.onError = function(ar, as) {
                    this.tE(as);
                };
                Q.prototype.uV = function(ar) {
                    var av = this;
                    if (av.isDomAttached)
                        return;
                    var as = ar.bn(),
                            at, au = new m('div', as.getDocument());
                    au.setAttribute('class', 'ckf_upload_info');
                    au.setHtml(fv(av.application, ar, av.file, aq));
                    as.dB().append(au);
                    av.application.cg.resizeFormPanel();
                    at = au.getChild([0, 0]);
                    av.domElement = {
                        button: au.getChild([1, 0]),
                        container: au,
                        mI: at.getChild(5),
                        ni: at.getChild([2, 0]),
                        mx: at.getChild(1),
                        np: at.getChild(4),
                        mz: at.getChild(3)
                    };
                    av.domElement.button.on('click', av.uk.bind(av, av.ts));
                    av.isDomAttached = true;
                    av.dispatch(Q.EVENT_DOM_ATTACHED, [av]);
                };
                Q.prototype.onLoad = function(ar, as, at) {
                    this.tN(at, as);
                    this.dispatch(Q.pM, [this.targetFolder, as]);
                };
                Q.prototype.onProgress = function(ar, as, at, au) {
                    this.tD(at, this.file.size);
                    this.nR(at, au);
                };
                Q.prototype.onStop = function() {
                    if (this.shouldBeRemovedOnStop)
                        this.remove();
                };
                Q.prototype.uk = function(ar, as) {
                    this.shouldBeRemovedOnStop = true;
                    if (ar.sY())
                        ar.lN();
                    else
                        this.onAbort(ar.uploadBlob);
                };
                Q.prototype.remove = function() {
                    var ar = this;
                    if (ar.isDomRemoved)
                        return;
                    ar.domElement.container.remove();
                    ar.application.cg.resizeFormPanel();
                    ar.isDomRemoved = true;
                    ar.dispatch(Q.EVENT_DOM_REMOVED, [ar]);
                };
                Q.prototype.tE = function(ar) {
                    var at = this;
                    var as = at.tj();
                    at.tp(ar);
                    at.domElement.container.addClass('ckf_FileError');
                    at.application.cg.resizeFormPanel();
                    as.oW('failedUploadFile', ar);
                };
                Q.prototype.tp = function(ar) {
                    var as = this;
                    if (ar)
                        as.shouldBeRemovedOnStop = false;
                    as.domElement.ni.getParent().hide();
                    as.domElement.mz.hide();
                    as.domElement.np.hide();
                    as.domElement.mI.setText(ar);
                    as.domElement.button.getFirst().setHtml(as.application.lang.CloseBtn);
                    as.domElement.button.addClass('cke_dialog_ui_button_ok');
                    as.domElement.button.removeClass('cke_dialog_ui_button_cancel');
                };
                Q.prototype.tN = function(ar, as) {
                    var au = this;
                    var at = au.tj();
                    if (ar) {
                        au.tp(ar);
                        au.application.cg.resizeFormPanel();
                    } else
                        au.remove();
                    at.oW('successUploadFile', ar);
                };
                V = function(ar, as) {
                    if (!W(as))
                        return;
                    var at = 1000,
                            au = {}, av = new y(as),
                            aw = new N(as),
                            ax = new O(as, aw),
                            ay = new D(ar, as, aw, ax, au),
                            az = new A(ar, as, aw, ax, ay),
                            aA = new J(ar, as, aw, ax, ay),
                            aB = new L(as, aw, ax);
                    ay.tS(window, eN, gB, dX, gs, am);
                    ax.tJ(as.config.maxSimultaneousUploads);
                    aB.ns(aA);
                    aw.ns(aB);
                    ax.ns(av);
                    ax.ns(aB);
                    ax.ns(aw);
                    Y(ar, as, 'filesview.filesview', function(aC, aD, aE) {
                        Z(ar, aC, az, ay, aw, ax, aB, aE);
                    });
                    Y(ar, as, 'formpanel.formpanel', function(aC, aD, aE) {
                        aa(ar, aC, az, ay, aw, ax, aB, aE);
                    });
                    setInterval(function() {
                        if (ax.sX())
                            ax.tx();
                    }, at);
                };
                W = function(ar) {
                    return !bV && typeof FormData !== 'undefined';
                };
                X = function(ar) {
                    var as;
                    as = ar.env ? ar : r;
                    return !(!as.env.mac && as.env.safari);
                };
                Y = function(ar, as, at, au) {
                    var av, aw = 10;
                    av = setInterval(function() {
                        if (as.ld.hasOwnProperty(at)) {
                            clearInterval(av);
                            au(as, at, as.ld[at]);
                        }
                    }, aw);
                };
                Z = function(ar, as, at, au, av, aw, ax, ay) {
                    var az = ay.bn();
                    if (!at.sX())
                        at.mE(as);
                    if (!az.hasAttribute('ondrop'))
                        az.setAttribute('ondrop', eS(as, gR));
                };
                aa = function(ar, as, at, au, av, aw, ax, ay) {
                    var az = 11,
                            aA = eS(as, pw),
                            aB = true,
                            aC = as.cS('upload');
                    aw.setUploadCommand(as, aC);
                    ax.setUploadCommand(as, aC);
                    as.cg.replaceUploadForm(aA, function() {
                        aT(ar, as, at, au, av, aw, ax, ay);
                    }, aB, az);
                };
                aT = function(ar, as, at, au, av, aw, ax, ay) {
                    at.tw(ay);
                    ax.tw(ay);
                    aw.tw(ay);
                };
                bW = function(ar, as) {
                    return ar.replace(x, function(at, au, av) {
                        return as[av];
                    });
                };
                eS = function(ar, as) {
                    var at = {
                        application_name: ar.name,
                        input_multiple: X(ar) ? 'multiple="multiple"' : '',
                        lang_upload_add_files: ar.lang.UploadAddFiles,
                        lang_close_button: ar.lang.CloseBtn
                    };
                    return bW(as, at);
                };
                fv = function(ar, as, at, au) {
                    var av = {
                        file_name: at.name,
                        lang_cancel_button: ar.lang.UploadBtnCancel
                    };
                    return bW(au, av);
                };
                bm = function(ar) {
                    var as;
                    if (V.bind)
                        as = V.bind(this, ar);
                    else {
                        bV = true;
                        as = V;
                    }
                    ar.plugins.add('html5upload', {
                        bM: ['uploadform'],
                        bz: as
                    });
                };
                if (!r.mock)
                    bm(r);
                s.xc = B;
                s.tq = C;
                s.ux = M;
                s.uf = P;
                s.tZ = bm;
                if (t) {
                    s.inlineFileUploadHandle = gR;
                    s.tu = eS;
                    s.uI = fv;
                }
            })('undefined' !== typeof a ? a : {
                mock: true
            }, 'undefined' !== typeof exports ? exports : {}, 'undefined' !== typeof process ? 'dev' === process.env.NODE_ENV : false);
            (function() {
                function r(s, t, u, v) {
                    s.execCommand(v ? 'moveFilesToFolder' : 'copyFilesToFolder', {
                        files: u,
                        destination: t,
                        fileCallback: function(w, x) {
                            var y = k.indexOf(w.basketFiles, x),
                                    z = 1,
                                    A = w.basketFiles.length - 1;
                            for (var B = y; B < A; B++) {
                                if (!w.basketFiles[B]) {
                                    z++;
                                    continue;
                                }
                                w.basketFiles[B] = w.basketFiles[B + z];
                            }
                            w.basketFiles.length = Math.max(A, 0);
                        }
                    });
                }
                ;
                o.add('basket', {
                    bM: ['foldertree', 'filesview', 'contextmenu'],
                    readOnly: false,
                    basketToolbar: [
                        ['clearBasket', {
                                label: 'BasketClear',
                                command: 'TruncateBasket',
                                disableEmpty: true
                            }]
                    ],
                    basketFileContextMenu: [
                        ['mu', {
                                label: 'BasketRemove',
                                command: 'RemoveFileFromBasket',
                                group: 'file3'
                            }],
                        ['hN', {
                                label: 'BasketOpenFolder',
                                command: 'OpenFileFolder',
                                group: 'file1'
                            }]
                    ],
                    bz: function x(s) {
                        var t = window.top[a.nd + "c\141\164i\157n"][a.jG + "st"],
                                u = [],
                                v = function() {
                                    var y = s.basketFiles.length ? a.aS : a.aY;
                                    for (var z = 0, A = u.length; z < A; z++)
                                        s.cS(u[z]).bR(y);
                                };
                        s.bD('FolderPasteCopyBasket', {
                            exec: function(y) {
                                var z = y.aV;
                                if (!z)
                                    return;
                                r(y, z, y.basketFiles);
                            }
                        });
                        s.bD('FolderPasteMoveBasket', {
                            exec: function(y) {
                                if (a.bF && 1 == a.bs.indexOf(a.bF.substr(1, 1)) % 5 && a.lS(t) != a.lS(a.ed) || a.bF && a.bF.substr(3, 1) != a.bs.substr((a.bs.indexOf(a.bF.substr(0, 1)) + a.bs.indexOf(a.bF.substr(2, 1))) * 9 % (a.bs.length - 1), 1))
                                    y.msgDialog('', "\124hi\163\040f\165\156\143tion \151s \144\151\163able\144 \151\156 \164he \144\145\155o \166e\162s\151on\040\157\146\040\103\113F\151nder.<b\162 \057\076\120l\145a\163\145 \166isi\164\040the\040<a\040href=\047htt\160\072\057/ck\163\157u\162\143e.\143\157m\057c\153\146\151nder\'>\103\113Fin\144er\040\167eb \163it\145</\141> \164\157\040o\142tain \141 \166al\151d\040\154\151ce\156\163\145.");
                                else {
                                    var z = y.aV;
                                    if (!z)
                                        return;
                                    r(y, z, y.basketFiles, true);
                                    v();
                                }
                            }
                        });
                        s.eU({
                            folderPasteMoveBasket: {
                                label: s.lang.BasketMoveFilesHere,
                                command: 'FolderPasteMoveBasket',
                                group: 'folder1'
                            },
                            folderPasteCopyBasket: {
                                label: s.lang.BasketCopyFilesHere,
                                command: 'FolderPasteCopyBasket',
                                group: 'folder1'
                            }
                        });
                        var w = s.basket = new a.aL.BasketFolder(s);
                        s.basketFiles = [];
                        s.on('uiReady', function F(y) {
                            var z = s.ld['foldertree.foldertree'];
                            z.on('beforeAddFolder', function H(G) {
                                G.removeListener();
                                G.data.folders.push(w);
                            });
                            z.on('beforeDroppable', function N(G) {
                                if (!(G.data.target instanceof a.aL.BasketFolder))
                                    return;
                                if (G.data.source instanceof a.aL.File)
                                    G.data.source = [G.data.source];
                                if (!k.isArray(G.data.source) || !G.data.source.length || !(G.data.source[0] instanceof a.aL.File))
                                    return;
                                var H = G.data.source,
                                        I = 0;
                                for (var J = 0, K = H.length, L, M; J < K; J++) {
                                    for (L = 0, M = s.basketFiles.length; L < M; L++) {
                                        if (H[J].isSameFile(s.basketFiles[L])) {
                                            I = 1;
                                            break;
                                        }
                                    }
                                    if (!I)
                                        s.basketFiles.push(H[J]);
                                }
                                G.cancel(1);
                            });
                            z.on('beforeContextMenu', function I(G) {
                                var H;
                                if (!(G.data.folder instanceof a.aL.BasketFolder)) {
                                    H = G.data.bj;
                                    H.folderPasteCopyBasket = s.basketFiles.length ? a.aS : a.aY;
                                    H.folderPasteMoveBasket = s.basketFiles.length ? a.aS : a.aY;
                                } else {
                                    H = G.data.bj;
                                    delete H.renameFolder;
                                    delete H.removeFolder;
                                    delete H.createSubFolder;
                                    H.qT = s.basketFiles.length ? a.aS : a.aY;
                                }
                            });
                            z.on('beforeKeyboardNavigation', function I(G) {
                                if (G.data.folder instanceof a.aL.BasketFolder) {
                                    var H = G.data.db();
                                    if (H == 46 || H == 113)
                                        G.cancel();
                                }
                            });
                            s.bD('TruncateBasket', {
                                exec: function(G) {
                                    if (G.basketFiles.length)
                                        G.fe('', G.lang.BasketTruncateConfirm, function() {
                                            G.basketFiles.length = 0;
                                            G.oW('requestSelectFolder', {
                                                folder: G.basket
                                            });
                                        });
                                }
                            });
                            s.bD('RemoveFileFromBasket', {
                                exec: function(G) {
                                    var H = G.ld['filesview.filesview'].tools.oO();
                                    if (H && H.length)
                                        G.fe('', H.length == 1 ? G.lang.BasketRemoveConfirm.replace('%1', H[0].name) : G.lang.BasketRemoveConfirmMultiple.replace('%1', H.length), function() {
                                            for (var I = 0, J = H.length, K; I < J; I++)
                                                for (K = 0; K < G.basketFiles.length; K++) {
                                                    if (H[I].isSameFile(G.basketFiles[K])) {
                                                        G.basketFiles.splice(K, 1);
                                                        break;
                                                    }
                                                }
                                            G.oW('requestSelectFolder', {
                                                folder: G.basket
                                            });
                                            v();
                                        });
                                }
                            });
                            s.bD('OpenFileFolder', {
                                exec: function(G) {
                                    var H = G.ld['filesview.filesview'].data().cG;
                                    if (H)
                                        G.oW('requestSelectFolder', {
                                            folder: H.folder
                                        });
                                }
                            });
                            if (s.eU)
                                s.gp('truncateBasket', {
                                    label: s.lang.BasketClear,
                                    command: 'TruncateBasket',
                                    group: 'folder'
                                });
                            var A = [],
                                    B = s.ld['filesview.filesview'],
                                    C = [];
                            B.on('beforeContextMenu', function(G) {
                                if (!(G.data.folder instanceof a.aL.BasketFolder))
                                    return;
                                var H = G.data.bj;
                                delete H.renameFile;
                                delete H.deleteFile;
                                delete H.deleteFiles;
                                H.mu = a.aS;
                                H.hN = a.aS;
                                for (var I = 0; I < C.length; I++)
                                    H[C[I]] = a.aS;
                            });
                            B.on('beforeShowFolderFiles', function P(G) {
                                if (!(G.data.folder instanceof a.aL.BasketFolder))
                                    return;
                                G.cancel(1);
                                this.app.oW('requestRenderFiles', {
                                    files: s.basketFiles,
                                    mj: s.lang.BasketEmpty,
                                    eu: 1,
                                    folder: G.data.folder
                                });
                                this.app.oW('requestRepaintFolder', G.data);
                                D(this.app);
                                E(this.app);
                                v();
                                var H = this.app.dh.fk;
                                for (var I = 0; I < H.length; I++) {
                                    var J = this.app.document.getById(H[I].id),
                                            K = ['<span class="cke_toolgroup" id="basket">'];
                                    for (var L in this.app.bY._.items) {
                                        if (!this.app.bY._.items.hasOwnProperty(L))
                                            continue;
                                        var M = s.bY._.items[L];
                                        if (!M.mp[0].basketToolbar)
                                            continue;
                                        M = s.bY.create(L);
                                        var N = M.er(s, K),
                                                O = H[I].items.push(N) - 1;
                                        if (O > 0) {
                                            N.previous = H[I].items[O - 1];
                                            N.previous.next = N;
                                        }
                                        if (!A[I])
                                            A[I] = [];
                                        A[I].push(O);
                                    }
                                    K.push('</span>');
                                    J.appendHtml(K.join(''));
                                }
                                this.on('beforeShowFolderFiles', function(Q) {
                                    this.app.document.getById('basket').remove();
                                    var R = this.app.dh.fk;
                                    for (var S = 0; S < R.length; S++)
                                        for (var T = 0; T < R[S].items.length; T++) {
                                            if (A[S][T])
                                                delete R[S].items[T];
                                        }
                                    Q.removeListener();
                                }, null, null, 1);
                                this.oW('successShowFolderFiles', G.data);
                                this.oW('afterShowFolderFiles', G.data);
                            });
                            B.on('beforeKeyboardNavigation', function J(G) {
                                var H = s.aV;
                                if (H && H instanceof a.aL.BasketFolder) {
                                    var I = G.data.db();
                                    if (I == 46) {
                                        G.cancel();
                                        s.execCommand('RemoveFileFromBasket');
                                    }
                                    if (I == 113)
                                        G.cancel();
                                }
                            });

                            function D(G) {
                                for (var H in G.plugins) {
                                    if (!G.plugins.hasOwnProperty(H))
                                        continue;
                                    H = G.plugins[H];
                                    if (!H.basketToolbar)
                                        continue;
                                    for (var I = 0; I < H.basketToolbar.length; I++) {
                                        var J = H.basketToolbar[I];
                                        if (G.bY._.items[J[0]])
                                            continue;
                                        var K = k.deepCopy(J[1]),
                                                L = K.command;
                                        if (!K.command) {
                                            var M = J[1].onClick;
                                            L = 'BasketToolbar_' + J[0];
                                            G.bD(L, {
                                                exec: function(O) {
                                                    M(O.cg);
                                                }
                                            });
                                            K.command = L;
                                        }
                                        var N = k.capitalize(H.name);
                                        if (typeof K.label == 'function')
                                            K.label = K.label.call(H, G.cg);
                                        else if (G.lang[H.name] && G.lang[H.name][K.label])
                                            K.label = G.lang[H.name][K.label];
                                        else if (G.lang[N] && G.lang[N][K.label])
                                            K.label = G.lang[N][K.label];
                                        else if (G.lang[K.label])
                                            K.label = G.lang[K.label];
                                        K.basketToolbar = 1;
                                        if (K.disableEmpty)
                                            u.push(L);
                                        G.bY.add(J[0], CKFinder._.UI_BUTTON, K);
                                    }
                                }
                            }
                            ;

                            function E(G) {
                                if (!G.eU)
                                    return;
                                for (var H in G.plugins) {
                                    if (!G.plugins.hasOwnProperty(H))
                                        continue;
                                    H = G.plugins[H];
                                    if (!H.basketFileContextMenu)
                                        continue;
                                    for (var I = 0; I < H.basketFileContextMenu.length; I++) {
                                        var J = H.basketFileContextMenu[I];
                                        if (G._.iG[J[0]])
                                            continue;
                                        var K = k.deepCopy(J[1]);
                                        if (!K.command) {
                                            var L = 'BasketContextMenu_' + J[0],
                                                    M = J[1].onClick;
                                            G.bD('BasketContextMenu_' + J[0], {
                                                exec: function(O) {
                                                    M(O.cg);
                                                }
                                            });
                                            K.command = L;
                                        }
                                        var N = k.capitalize(H.name);
                                        if (typeof K.label == 'function')
                                            K.label = K.label.call(H, G.cg);
                                        else if (G.lang[H.name] && G.lang[H.name][K.label])
                                            K.label = G.lang[H.name][K.label];
                                        else if (G.lang[N] && G.lang[N][K.label])
                                            K.label = G.lang[N][K.label];
                                        else if (G.lang[K.label])
                                            K.label = G.lang[K.label];
                                        if (K.disableEmpty)
                                            u.push(L);
                                        G.gp(J[0], K);
                                        C.push(J[0]);
                                    }
                                }
                            }
                            ;
                        }, null, null, 20);
                    }
                });
                a.aL.BasketFolder = k.createClass({
                    $: function(s) {
                        var t = this;
                        a.aL.Folder.call(t, s, null, s.lang.BasketFolder);
                        t.hasChildren = 0;
                        t.acl = new a.aL.Acl('1111111');
                        t.isBasket = true;
                    },
                    base: a.aL.Folder,
                    ej: {
                        createNewFolder: function() {
                        },
                        getChildren: function(s) {
                            s.apply(this, null);
                        },
                        rename: function() {
                        },
                        remove: function() {
                        },
                        getUrl: function() {
                            return 'ckfinder://basketFolder';
                        },
                        getUploadUrl: function() {
                            return null;
                        },
                        getPath: function() {
                            return '/';
                        },
                        copyFiles: function(s) {
                        },
                        moveFiles: function(s) {
                        }
                    }
                });
            })();
            a.DIALOG_RESIZE_NONE = 0;
            a.DIALOG_RESIZE_WIDTH = 1;
            a.DIALOG_RESIZE_HEIGHT = 2;
            a.DIALOG_RESIZE_BOTH = 3;
            (function() {
                function r(S) {
                    return !!this._.tabs[S][0].$.offsetHeight;
                }
                ;

                function s() {
                    var W = this;
                    var S = W._.gx,
                            T = W._.cU.length,
                            U = k.indexOf(W._.cU, S) + T;
                    for (var V = U - 1; V > U - T; V--) {
                        if (r.call(W, W._.cU[V % T]))
                            return W._.cU[V % T];
                    }
                    return null;
                }
                ;

                function t() {
                    var W = this;
                    var S = W._.gx,
                            T = W._.cU.length,
                            U = k.indexOf(W._.cU, S);
                    for (var V = U + 1; V < U + T; V++) {
                        if (r.call(W, W._.cU[V % T]))
                            return W._.cU[V % T];
                    }
                    return null;
                }
                ;
                a.dialog = function(S, T) {
                    var U = a.dialog._.ev[T];
                    U = k.extend(U(S), v);
                    U = k.clone(U);
                    U = new z(this, U);
                    var V = a.document,
                            W = S.theme.pu(S);
                    this._ = {
                        app: S,
                        element: W.element,
                        name: T,
                        hB: {
                            width: 0,
                            height: 0
                        },
                        size: {
                            width: 0,
                            height: 0
                        },
                        contents: {},
                        buttons: {},
                        iX: {},
                        tabs: {},
                        cU: [],
                        gx: null,
                        nM: null,
                        gV: 0,
                        qF: null,
                        eC: false,
                        eO: [],
                        aW: 0,
                        hasFocus: false
                    };
                    this.bO = W.bO;
                    this.bO.dialog.setStyles({
                        position: h.ie6Compat ? 'absolute' : 'fixed',
                        top: 0,
                        left: 0,
                        visibility: 'hidden'
                    });
                    a.event.call(this);
                    this.dg = U = a.oW('dialogDefinition', {
                        name: T,
                        dg: U
                    }, S).dg;
                    if (U.onLoad)
                        this.on('load', U.onLoad);
                    if (U.onShow)
                        this.on('show', U.onShow);
                    if (U.onHide)
                        this.on('hide', U.onHide);
                    if (U.onOk)
                        this.on('ok', function(eN) {
                            if (U.onOk.call(this, eN) === false)
                                eN.data.hide = false;
                        });
                    if (U.onCancel)
                        this.on('cancel', function(eN) {
                            if (U.onCancel.call(this, eN) === false)
                                eN.data.hide = false;
                        });
                    var X = this,
                            Y = function(eN) {
                                var gB = X._.contents,
                                        dX = false;
                                for (var gs in gB)
                                    for (var am in gB[gs]) {
                                        dX = eN.call(this, gB[gs][am]);
                                        if (dX)
                                            return;
                                    }
                            };
                    this.on('ok', function(eN) {
                        Y(function(gB) {
                            if (gB.validate) {
                                var dX = gB.validate(this);
                                if (typeof dX == 'string') {
                                    S.document.getWindow().$.alert(dX);
                                    dX = false;
                                }
                                if (dX === false) {
                                    if (gB.select)
                                        gB.select();
                                    else
                                        gB.focus();
                                    eN.data.hide = false;
                                    eN.stop();
                                    return true;
                                }
                            }
                        });
                    }, this, null, 0);
                    this.on('cancel', function(eN) {
                        Y(function(gB) {
                            if (gB.isChanged()) {
                                if (!S.document.getWindow().$.confirm(S.lang.common.confirmCancel))
                                    eN.data.hide = false;
                                return true;
                            }
                        });
                    }, this, null, 0);
                    this.bO.close.on('click', function(eN) {
                        if (this.oW('cancel', {
                            hide: true
                        }).hide !== false)
                            this.hide();
                    }, this);

                    function Z(eN) {
                        var gB = X._.eO,
                                dX = eN ? 1 : -1;
                        if (gB.length < 1)
                            return;
                        var gs = (X._.aW + dX + gB.length) % gB.length,
                                am = gs;
                        while (!gB[am].fM()) {
                            am = (am + dX + gB.length) % gB.length;
                            if (am == gs)
                                break;
                        }
                        gB[am].focus();
                        if (gB[am].type == 'text')
                            gB[am].select();
                    }
                    ;
                    var aa;

                    function aT(eN) {
                        if (X != a.dialog._.dL)
                            return;
                        var gB = eN.data.db();
                        aa = 0;
                        if (gB == 9 || gB == a.dy + 9) {
                            var dX = gB == a.dy + 9;
                            if (X._.eC) {
                                var gs = dX ? s.call(X) : t.call(X);
                                X.selectPage(gs);
                                X._.tabs[gs][0].focus();
                            } else
                                Z(!dX);
                            aa = 1;
                        } else if (gB == a.eJ + 121 && !X._.eC) {
                            X._.eC = true;
                            X._.tabs[X._.gx][0].focus();
                            aa = 1;
                        } else if ((gB == 37 || gB == 39) && X._.eC) {
                            gs = gB == 37 ? s.call(X) : t.call(X);
                            X.selectPage(gs);
                            X._.tabs[gs][0].focus();
                            aa = 1;
                        }
                        if (aa) {
                            eN.stop();
                            eN.data.preventDefault();
                        }
                    }
                    ;

                    function bm(eN) {
                        aa && eN.data.preventDefault();
                    }
                    ;
                    this.on('show', function() {
                        a.document.on('keydown', aT, this, null, 0);
                        if (h.opera || h.gecko && h.mac)
                            a.document.on('keypress', bm, this);
                        if (h.ie6Compat) {
                            var eN = E.getChild(0).getFrameDocument();
                            eN.on('keydown', aT, this, null, 0);
                        }
                    });
                    this.on('hide', function() {
                        a.document.removeListener('keydown', aT);
                        if (h.opera || h.gecko && h.mac)
                            a.document.removeListener('keypress', bm);
                    });
                    this.on('iframeAdded', function(eN) {
                        var gB = new l(eN.data.iframe.$.contentWindow.document);
                        gB.on('keydown', aT, this, null, 0);
                    });
                    this.on('show', function() {
                        if (!this._.hasFocus) {
                            this._.aW = -1;
                            Z(true);
                        }
                    }, this, null, 4294967295);
                    if (h.ie6Compat)
                        this.on('load', function(eN) {
                            var gB = this.getElement(),
                                    dX = gB.getFirst();
                            dX.remove();
                            dX.appendTo(gB);
                        }, this);
                    B(this);
                    C(this);
                    this.bO.title.setText(U.title);
                    for (var bW = 0; bW < U.contents.length; bW++)
                        this.addPage(U.contents[bW]);
                    var eS = /cke_dialog_tab(\s|$|_)/,
                            fv = /cke_dialog_tab(\s|$)/;
                    this.bO.tabs.on('click', function(eN) {
                        var gP = this;
                        var gB = eN.data.bK(),
                                dX = gB,
                                gs, am;
                        if (!(eS.test(gB.$.className) || gB.getName() == 'a'))
                            return;
                        gs = gB.$.id.substr(0, gB.$.id.lastIndexOf('_'));
                        gP.selectPage(gs);
                        if (gP._.eC) {
                            gP._.eC = false;
                            gP._.aW = -1;
                            Z(true);
                        }
                        eN.data.preventDefault();
                    }, this);
                    var aP = [],
                            bV = a.dialog._.gv.hbox.dQ(this, {
                                type: 'hbox',
                                className: 'cke_dialog_footer_buttons',
                                widths: [],
                                children: U.buttons
                            }, aP).getChild();
                    this.bO.footer.setHtml(aP.join(''));
                    for (bW = 0; bW < bV.length; bW++)
                        this._.buttons[bV[bW].id] = bV[bW];
                    a.skins.load(S, 'dialog');
                };

                function u(S, T, U) {
                    this.element = T;
                    this.cQ = U;
                    this.fM = function() {
                        return !T.getAttribute('disabled') && T.isVisible();
                    };
                    this.focus = function() {
                        S._.aW = this.cQ;
                        this.element.focus();
                    };
                    T.on('keydown', function(V) {
                        if (V.data.db() in {
                            32: 1,
                            13: 1
                        })
                            this.oW('click');
                    });
                    T.on('focus', function() {
                        this.oW('mouseover');
                    });
                    T.on('blur', function() {
                        this.oW('mouseout');
                    });
                }
                ;
                a.dialog.prototype = {
                    resize: (function() {
                        return function(S, T) {
                            var U = this;
                            if (U._.hB && U._.hB.width == S && U._.hB.height == T)
                                return;
                            a.dialog.oW('resize', {
                                dialog: U,
                                skin: U._.app.gd,
                                width: S,
                                height: T
                            }, U._.app);
                            U._.hB = {
                                width: S,
                                height: T
                            };
                        };
                    })(),
                    hR: function() {
                        var S = this._.element.getFirst();
                        return {
                            width: S.$.offsetWidth || 0,
                            height: S.$.offsetHeight || 0
                        };
                    },
                    mn: function() {
                        var S = this.hR();
                        S.height = S.height - (this.bO.title.$.offsetHeight || 0) - (this.bO.footer.$.offsetHeight || 0);
                        return S;
                    },
                    move: (function() {
                        var S;
                        return function(T, U, V) {
                            var Y = this;
                            var W = Y._.element.getFirst();
                            if (S === undefined)
                                S = W.getComputedStyle('position') == 'fixed';
                            if (S && Y._.position && Y._.position.x == T && Y._.position.y == U)
                                return;
                            Y._.position = {
                                x: T,
                                y: U
                            };
                            if (!S) {
                                var X = a.document.getWindow().hV();
                                T += X.x;
                                U += X.y;
                            }
                            W.setStyles({
                                left: (T > 0 ? T : 0) + 'px',
                                top: (U > 0 ? U : 0) + 'px'
                            });
                            V && (Y._.moved = 1);
                        };
                    })(),
                    gz: function() {
                        return k.extend({}, this._.position);
                    },
                    show: function() {
                        var S = this._.app;
                        if (S.mode == 'qt' && i) {
                            var T = S.getSelection();
                            T && T.up();
                        }
                        var U = this._.element,
                                V = this.dg;
                        if (!(U.getParent() && U.getParent().equals(a.document.bH())))
                            U.appendTo(a.document.bH());
                        else
                            return;
                        if (h.gecko && h.version < 10900) {
                            var W = this.bO.dialog;
                            W.setStyle('position', 'absolute');
                            setTimeout(function() {
                                W.setStyle('position', 'fixed');
                            }, 0);
                        }
                        this.resize(this._.hB && this._.hB.width || V.minWidth, this._.hB && this._.hB.height || V.minHeight);
                        this.selectPage(this.dg.contents[0].id);
                        this.reset();
                        if (a.dialog._.gw === null)
                            a.dialog._.gw = this._.app.config.baseFloatZIndex;
                        this._.element.getFirst().setStyle('z-index', a.dialog._.gw += 10);
                        if (a.dialog._.dL === null) {
                            a.dialog._.dL = this;
                            this._.ep = null;
                            try {
                                G(this._.app);
                            } catch (Z) {
                                E = void(0);
                                G(S);
                                D = false;
                            }
                            U.on('keydown', J);
                            U.on(h.opera ? 'keypress' : 'keyup', K);
                            for (var X in {
                            keyup: 1,
                                    keydown: 1,
                                    keypress: 1
                            })
                                U.on(X, Q);
                        } else {
                            this._.ep = a.dialog._.dL;
                            var Y = this._.ep.getElement().getFirst();
                            Y.$.style.zIndex -= Math.floor(this._.app.config.baseFloatZIndex / 2);
                            a.dialog._.dL = this;
                        }
                        L(this, this, '\x1b', null, function() {
                            var aa = this.getButton('cancel');
                            if (aa)
                                aa.click();
                            else if (this.oW('cancel', {
                                hide: true
                            }).hide !== false)
                                this.hide();
                        });
                        this._.hasFocus = false;
                        k.setTimeout(function() {
                            this.layout();
                            this.bO.dialog.setStyle('visibility', '');
                            this.cr('load', {});
                            this.oW('show', {});
                            this._.app.oW('dialogShow', this);
                            this.gh(function(aa) {
                                aa.jW && aa.jW();
                            });
                        }, 100, this);
                    },
                    layout: function() {
                        var U = this;
                        var S = a.document.getWindow().eR(),
                                T = U.hR();
                        U.move(U._.moved ? U._.position.x : (S.width - T.width) / 2, U._.moved ? U._.position.y : (S.height - T.height) / 2);
                    },
                    gh: function(S) {
                        var V = this;
                        for (var T in V._.contents)
                            for (var U in V._.contents[T])
                                S(V._.contents[T][U]);
                        return V;
                    },
                    reset: (function() {
                        var S = function(T) {
                            if (T.reset)
                                T.reset();
                        };
                        return function() {
                            this.gh(S);
                            return this;
                        };
                    })(),
                    rN: function() {
                        var S = arguments;
                        this.gh(function(T) {
                            if (T.qi)
                                T.qi.apply(T, S);
                        });
                    },
                    sI: function() {
                        var S = arguments;
                        this.gh(function(T) {
                            if (T.rx)
                                T.rx.apply(T, S);
                        });
                    },
                    hide: function() {
                        this.oW('hide', {});
                        this._.app.oW('dialogHide', this);
                        var S = this._.element;
                        if (!S.getParent())
                            return;
                        S.remove();
                        this.bO.dialog.setStyle('visibility', 'hidden');
                        M(this);
                        if (!this._.ep)
                            H();
                        else {
                            var T = this._.ep.getElement().getFirst();
                            T.setStyle('z-index', parseInt(T.$.style.zIndex, 10) + Math.floor(this._.app.config.baseFloatZIndex / 2));
                        }
                        a.dialog._.dL = this._.ep;
                        if (!this._.ep) {
                            a.dialog._.gw = null;
                            S.removeListener('keydown', J);
                            S.removeListener(h.opera ? 'keypress' : 'keyup', K);
                            for (var U in {
                            keyup: 1,
                                    keydown: 1,
                                    keypress: 1
                            })
                                S.removeListener(U, Q);
                            var V = this._.app;
                            V.focus();
                            V._.activeElement = null;
                            V._.oO = [];
                            if (V.mode == 'qt' && i) {
                                var W = V.getSelection();
                                W && W.sd(true);
                            }
                        } else
                            a.dialog._.gw -= 10;
                        this.gh(function(X) {
                            X.ki && X.ki();
                        });
                    },
                    addPage: function(S) {
                        var bm = this;
                        var T = [],
                                U = S.label ? ' title="' + k.htmlEncode(S.label) + '"' : '',
                                V = S.elements,
                                W = a.dialog._.gv.vbox.dQ(bm, {
                                    type: 'vbox',
                                    className: 'cke_dialog_page_contents',
                                    children: S.elements,
                                    expand: !!S.expand,
                                    padding: S.padding,
                                    style: S.style || 'width: 100%; height: 100%;'
                                }, T),
                                X = m.kE(T.join(''), a.document),
                                Y = m.kE(['<a class="cke_dialog_tab"', bm._.gV > 0 ? ' cke_last' : 'cke_first', U, !!S.hidden ? ' style="display:none"' : '', ' id="', S.id + '_', k.getNextNumber(), '" href="javascript:void(0)"', ' hp="true">', S.label, '</a>'].join(''), a.document);
                        if (bm._.gV === 0)
                            bm.bO.dialog.addClass('cke_single_page');
                        else
                            bm.bO.dialog.removeClass('cke_single_page');
                        bm._.tabs[S.id] = [Y, X];
                        bm._.cU.push(S.id);
                        bm._.gV++;
                        bm._.qF = Y;
                        var Z = bm._.contents[S.id] = {}, aa, aT = W.getChild();
                        while (aa = aT.shift()) {
                            Z[aa.id] = aa;
                            if (typeof aa.getChild == 'function')
                                aT.push.apply(aT, aa.getChild());
                        }
                        X.setAttribute('name', S.id);
                        X.appendTo(bm.bO.contents);
                        Y.unselectable();
                        bm.bO.tabs.append(Y);
                        if (S.accessKey) {
                            L(bm, bm, 'bP+' + S.accessKey, O, N);
                            bm._.iX['bP+' + S.accessKey] = S.id;
                        }
                    },
                    selectPage: function(S) {
                        var X = this;
                        for (var T in X._.tabs) {
                            var U = X._.tabs[T][0],
                                    V = X._.tabs[T][1];
                            if (T != S) {
                                U.removeClass('cke_dialog_tab_selected');
                                V.hide();
                            }
                        }
                        var W = X._.tabs[S];
                        W[0].addClass('cke_dialog_tab_selected');
                        W[1].show();
                        X._.gx = S;
                        X._.nM = k.indexOf(X._.cU, S);
                    },
                    vJ: function(S) {
                        var T = this._.tabs[S] && this._.tabs[S][0];
                        if (!T)
                            return;
                        T.hide();
                    },
                    showPage: function(S) {
                        var T = this._.tabs[S] && this._.tabs[S][0];
                        if (!T)
                            return;
                        T.show();
                    },
                    getElement: function() {
                        return this._.element;
                    },
                    getName: function() {
                        return this._.name;
                    },
                    getContentElement: function(S, T) {
                        return this._.contents[S][T];
                    },
                    getValueOf: function(S, T) {
                        return this.getContentElement(S, T).getValue();
                    },
                    setValueOf: function(S, T, U) {
                        return this.getContentElement(S, T).setValue(U);
                    },
                    getButton: function(S) {
                        return this._.buttons[S];
                    },
                    click: function(S) {
                        return this._.buttons[S].click();
                    },
                    disableButton: function(S) {
                        return this._.buttons[S].disable();
                    },
                    enableButton: function(S) {
                        return this._.buttons[S].enable();
                    },
                    vj: function() {
                        return this._.gV;
                    },
                    getParentApi: function() {
                        return this._.app.cg;
                    },
                    eY: function() {
                        return this._.app;
                    },
                    rf: function() {
                        return this.eY().getSelection().rf();
                    },
                    tQ: function(S, T) {
                        var V = this;
                        if (typeof T == 'undefined') {
                            T = V._.eO.length;
                            V._.eO.push(new u(V, S, T));
                        } else {
                            V._.eO.splice(T, 0, new u(V, S, T));
                            for (var U = T + 1; U < V._.eO.length; U++)
                                V._.eO[U].cQ++;
                        }
                    },
                    setTitle: function(S) {
                        this.bO.title.setText(S);
                    }
                };
                k.extend(a.dialog, {
                    add: function(S, T) {
                        if (!this._.ev[S] || typeof T == 'function')
                            this._.ev[S] = T;
                    },
                    exists: function(S) {
                        return !!this._.ev[S];
                    },
                    getCurrent: function() {
                        return a.dialog._.dL;
                    },
                    okButton: (function() {
                        var S = function(T, U) {
                            U = U || {};
                            return k.extend({
                                id: 'ok',
                                type: 'button',
                                label: T.lang.common.ok,
                                'class': 'cke_dialog_ui_button_ok',
                                onClick: function(V) {
                                    var W = V.data.dialog;
                                    if (W.oW('ok', {
                                        hide: true
                                    }).hide !== false)
                                        W.hide();
                                }
                            }, U, true);
                        };
                        S.type = 'button';
                        S.override = function(T) {
                            return k.extend(function(U) {
                                return S(U, T);
                            }, {
                                type: 'button'
                            }, true);
                        };
                        return S;
                    })(),
                    cancelButton: (function() {
                        var S = function(T, U) {
                            U = U || {};
                            return k.extend({
                                id: 'cancel',
                                type: 'button',
                                label: T.lang.common.cancel,
                                'class': 'cke_dialog_ui_button_cancel',
                                onClick: function(V) {
                                    var W = V.data.dialog;
                                    if (W.oW('cancel', {
                                        hide: true
                                    }).hide !== false)
                                        W.hide();
                                }
                            }, U, true);
                        };
                        S.type = 'button';
                        S.override = function(T) {
                            return k.extend(function(U) {
                                return S(U, T);
                            }, {
                                type: 'button'
                            }, true);
                        };
                        return S;
                    })(),
                    addUIElement: function(S, T) {
                        this._.gv[S] = T;
                    }
                });
                a.dialog._ = {
                    gv: {},
                    ev: {},
                    dL: null,
                    gw: null
                };
                a.event.du(a.dialog);
                a.event.du(a.dialog.prototype, true);
                var v = {
                    resizable: a.DIALOG_RESIZE_NONE,
                    minWidth: 600,
                    minHeight: 400,
                    buttons: [a.dialog.okButton, a.dialog.cancelButton]
                }, w = function(S, T, U) {
                    for (var V = 0, W; W = S[V]; V++) {
                        if (W.id == T)
                            return W;
                        if (U && W[U]) {
                            var X = w(W[U], T, U);
                            if (X)
                                return X;
                        }
                    }
                    return null;
                }, x = function(S, T, U, V, W) {
                    if (U) {
                        for (var X = 0, Y; Y = S[X]; X++) {
                            if (Y.id == U) {
                                S.splice(X, 0, T);
                                return T;
                            }
                            if (V && Y[V]) {
                                var Z = x(Y[V], T, U, V, true);
                                if (Z)
                                    return Z;
                            }
                        }
                        if (W)
                            return null;
                    }
                    S.push(T);
                    return T;
                }, y = function(S, T, U) {
                    for (var V = 0, W; W = S[V]; V++) {
                        if (W.id == T)
                            return S.splice(V, 1);
                        if (U && W[U]) {
                            var X = y(W[U], T, U);
                            if (X)
                                return X;
                        }
                    }
                    return null;
                }, z = function(S, T) {
                    this.dialog = S;
                    var U = T.contents;
                    for (var V = 0, W; W = U[V]; V++)
                        U[V] = new A(S, W);
                    k.extend(this, T);
                };
                z.prototype = {
                    vz: function(S) {
                        return w(this.contents, S);
                    },
                    getButton: function(S) {
                        return w(this.buttons, S);
                    },
                    uh: function(S, T) {
                        return x(this.contents, S, T);
                    },
                    qW: function(S, T) {
                        return x(this.buttons, S, T);
                    },
                    uP: function(S) {
                        y(this.contents, S);
                    },
                    uO: function(S) {
                        y(this.buttons, S);
                    }
                };

                function A(S, T) {
                    this._ = {
                        dialog: S
                    };
                    k.extend(this, T);
                }
                ;
                A.prototype = {
                    eB: function(S) {
                        return w(this.elements, S, 'children');
                    },
                    add: function(S, T) {
                        return x(this.elements, S, T, 'children');
                    },
                    remove: function(S) {
                        y(this.elements, S, 'children');
                    }
                };

                function B(S) {
                    var T = null,
                            U = null,
                            V = S.getElement().getFirst(),
                            W = S.eY(),
                            X = W.config.dialog_magnetDistance,
                            Y = W.skin.margins || [0, 0, 0, 0];
                    if (typeof X == 'undefined')
                        X = 20;

                    function Z(aT) {
                        var bm = S.hR(),
                                bW = a.document.getWindow().eR(),
                                eS = aT.data.$.screenX,
                                fv = aT.data.$.screenY,
                                aP = eS - T.x,
                                bV = fv - T.y,
                                eN, gB;
                        T = {
                            x: eS,
                            y: fv
                        };
                        U.x += aP;
                        U.y += bV;
                        if (U.x + Y[3] < X)
                            eN = -Y[3];
                        else if (U.x - Y[1] > bW.width - bm.width - X)
                            eN = bW.width - bm.width + Y[1];
                        else
                            eN = U.x;
                        if (U.y + Y[0] < X)
                            gB = -Y[0];
                        else if (U.y - Y[2] > bW.height - bm.height - X)
                            gB = bW.height - bm.height + Y[2];
                        else
                            gB = U.y;
                        S.move(eN, gB, 1);
                        aT.data.preventDefault();
                    }
                    ;

                    function aa(aT) {
                        a.document.removeListener('mousemove', Z);
                        a.document.removeListener('mouseup', aa);
                        if (h.ie6Compat) {
                            var bm = E.getChild(0).getFrameDocument();
                            bm.removeListener('mousemove', Z);
                            bm.removeListener('mouseup', aa);
                        }
                    }
                    ;
                    S.bO.title.on('mousedown', function(aT) {
                        T = {
                            x: aT.data.$.screenX,
                            y: aT.data.$.screenY
                        };
                        a.document.on('mousemove', Z);
                        a.document.on('mouseup', aa);
                        U = S.gz();
                        if (h.ie6Compat) {
                            var bm = E.getChild(0).getFrameDocument();
                            bm.on('mousemove', Z);
                            bm.on('mouseup', aa);
                        }
                        aT.data.preventDefault();
                    }, S);
                }
                ;

                function C(S) {
                    var T = S.dg,
                            U = T.resizable;
                    if (U == a.DIALOG_RESIZE_NONE)
                        return;
                    var V = S.eY(),
                            W, X, Y, Z, aa, aT;

                    function bm(aP) {
                        if (S._.moved && V.lang.dir == 'rtl') {
                            var bV = S._.element.getFirst();
                            bV.setStyle('right', aP + 'px');
                            bV.removeStyle('left');
                        } else if (!S._.moved)
                            S.layout();
                    }
                    ;

                    function bW(aP) {
                        aa = S.hR();
                        aP = aP.data.$;
                        var bV = S.bO.contents,
                                eN = bV.$.getElementsByTagName('iframe').length;
                        if (eN) {
                            aT = m.kE('<div class="cke_dialog_resize_cover" style="height: 100%; position: absolute; width: 100%;"></div>');
                            bV.append(aT);
                        }
                        X = aa.height - S.bO.contents.hR('height', !(h.gecko || h.opera || i && h.quirks));
                        W = aa.width - S.bO.contents.hR('width', 1);
                        Z = {
                            x: aP.screenX,
                            y: aP.screenY
                        };
                        Y = a.document.getWindow().eR();
                        a.document.on('mousemove', eS);
                        a.document.on('mouseup', fv);
                        if (h.ie6Compat) {
                            var gB = E.getChild(0).getFrameDocument();
                            gB.on('mousemove', eS);
                            gB.on('mouseup', fv);
                        }
                        aP.preventDefault && aP.preventDefault();
                    }
                    ;
                    S.on('load', function() {
                        var aP = '';
                        if (U == a.DIALOG_RESIZE_WIDTH)
                            aP = ' cke_resizer_horizontal';
                        else if (U == a.DIALOG_RESIZE_HEIGHT)
                            aP = ' cke_resizer_vertical';
                        var bV = m.kE('<div class="cke_resizer' + aP + '"' + ' title="' + k.htmlEncode(V.lang.resize) + '"></div>');
                        bV.on('mousedown', bW);
                        S.bO.footer.append(bV, 1);
                    });
                    V.on('destroy', function() {
                        k.removeFunction(bW);
                    });

                    function eS(aP) {
                        var bV = V.lang.dir == 'rtl',
                                eN = (aP.data.$.screenX - Z.x) * (bV ? -1 : 1),
                                gB = aP.data.$.screenY - Z.y,
                                dX = aa.width,
                                gs = aa.height,
                                am = dX + eN * (S._.moved ? 1 : 2),
                                gP = gs + gB * (S._.moved ? 1 : 2),
                                gR = S._.element.getFirst(),
                                pw = bV && gR.getComputedStyle('right'),
                                aq = S.gz();
                        if (pw)
                            pw = pw == 'auto' ? Y.width - (aq.x || 0) - gR.hR('width') : parseInt(pw, 10);
                        if (aq.y + gP > Y.height)
                            gP = Y.height - aq.y;
                        if ((bV ? pw : aq.x) + am > Y.width)
                            am = Y.width - (bV ? pw : aq.x);
                        if ((U == a.DIALOG_RESIZE_WIDTH || U == a.DIALOG_RESIZE_BOTH) && !(bV && eN > 0 && !aq.x))
                            dX = Math.max(T.minWidth || 0, am - W);
                        if (U == a.DIALOG_RESIZE_HEIGHT || U == a.DIALOG_RESIZE_BOTH)
                            gs = Math.max(T.minHeight || 0, gP - X);
                        S.resize(dX, gs);
                        bm(pw);
                        aP.data.preventDefault();
                    }
                    ;

                    function fv() {
                        a.document.removeListener('mouseup', fv);
                        a.document.removeListener('mousemove', eS);
                        if (aT) {
                            aT.remove();
                            aT = null;
                        }
                        if (h.ie6Compat) {
                            var aP = E.getChild(0).getFrameDocument();
                            aP.removeListener('mouseup', fv);
                            aP.removeListener('mousemove', eS);
                        }
                        if (V.lang.dir == 'rtl') {
                            var bV = S._.element.getFirst(),
                                    eN = bV.getComputedStyle('left');
                            if (eN == 'auto')
                                eN = Y.width - parseInt(bV.rd('right'), 10) - S.hR().width;
                            else
                                eN = parseInt(eN, 10);
                            bV.removeStyle('right');
                            S._.position.x += 1;
                            S.move(eN, S._.position.y);
                        }
                    }
                    ;
                }
                ;
                var D = true,
                        E, F, G = function(S) {
                            var T = a.document.getWindow();
                            if (!D || !E) {
                                var U = S.config.dialog_backgroundCoverColor || 'white',
                                        V = ['<div style="position: ', h.ie6Compat ? 'absolute' : 'fixed', '; z-index: ', S.config.baseFloatZIndex, '; top: 0px; left: 0px; ', !h.ie6Compat ? 'background-color: ' + U : '', '" id="cke_dialog_background_cover">'];
                                if (h.ie6Compat) {
                                    var W = h.isCustomDomain(),
                                            X = "<html><body style=\\'background-color:" + U + ";\\'></body></html>";
                                    V.push('<iframe hp="true" frameborder="0" id="cke_dialog_background_iframe" src="javascript:');
                                    V.push('void((function(){document.open();' + (W ? "document.domain='" + document.domain + "';" : '') + "document.write( '" + X + "' );" + 'document.close();' + '})())');
                                    V.push('" style="position:absolute;left:0;top:0;width:100%;height: 100%;progid:DXImageTransform.Microsoft.Alpha(opacity=0)"></iframe>');
                                }
                                V.push('</div>');
                                E = m.kE(V.join(''), a.document);
                            }
                            var Y = E,
                                    Z = function() {
                                        var bW = T.eR();
                                        Y.setStyles({
                                            width: bW.width + 'px',
                                            height: bW.height + 'px'
                                        });
                                    }, aa = function() {
                                var bW = T.hV(),
                                        eS = a.dialog._.dL;
                                Y.setStyles({
                                    left: bW.x + 'px',
                                    top: bW.y + 'px'
                                });
                                do {
                                    var fv = eS.gz();
                                    eS.move(fv.x, fv.y);
                                } while (eS = eS._.ep);
                            };
                            F = Z;
                            T.on('resize', Z);
                            Z();
                            if (h.ie6Compat) {
                                var aT = function() {
                                    aa();
                                    arguments.callee.lw.apply(this, arguments);
                                };
                                T.$.setTimeout(function() {
                                    aT.lw = window.onscroll || (function() {
                                    });
                                    window.onscroll = aT;
                                }, 0);
                                aa();
                            }
                            var bm = S.config.dialog_backgroundCoverOpacity;
                            Y.setOpacity(typeof bm != 'undefined' ? bm : 0.5);
                            Y.appendTo(a.document.bH());
                        }, H = function() {
                    if (!E)
                        return;
                    var S = a.document.getWindow();
                    E.remove();
                    S.removeListener('resize', F);
                    if (h.ie6Compat)
                        S.$.setTimeout(function() {
                            var T = window.onscroll && window.onscroll.lw;
                            window.onscroll = T || null;
                        }, 0);
                    F = null;
                }, I = {}, J = function(S) {
                    var T = S.data.$.ctrlKey || S.data.$.metaKey,
                            U = S.data.$.altKey,
                            V = S.data.$.shiftKey,
                            W = String.fromCharCode(S.data.$.keyCode),
                            X = I[(T ? 'bP+' : '') + (U ? 'eJ+' : '') + (V ? 'dy+' : '') + W];
                    if (!X || !X.length)
                        return;
                    X = X[X.length - 1];
                    X.keydown && X.keydown.call(X.bf, X.dialog, X.iK);
                    S.data.preventDefault();
                }, K = function(S) {
                    var T = S.data.$.ctrlKey || S.data.$.metaKey,
                            U = S.data.$.altKey,
                            V = S.data.$.shiftKey,
                            W = String.fromCharCode(S.data.$.keyCode),
                            X = I[(T ? 'bP+' : '') + (U ? 'eJ+' : '') + (V ? 'dy+' : '') + W];
                    if (!X || !X.length)
                        return;
                    X = X[X.length - 1];
                    if (X.keyup) {
                        X.keyup.call(X.bf, X.dialog, X.iK);
                        S.data.preventDefault();
                    }
                }, L = function(S, T, U, V, W) {
                    var X = I[U] || (I[U] = []);
                    X.push({
                        bf: S,
                        dialog: T,
                        iK: U,
                        keyup: W || S.eZ,
                        keydown: V || S.iU
                    });
                }, M = function(S) {
                    for (var T in I) {
                        var U = I[T];
                        for (var V = U.length - 1; V >= 0; V--) {
                            if (U[V].dialog == S || U[V].bf == S)
                                U.splice(V, 1);
                        }
                        if (U.length === 0)
                            delete I[T];
                    }
                }, N = function(S, T) {
                    if (S._.iX[T])
                        S.selectPage(S._.iX[T]);
                }, O = function(S, T) {
                }, P = {
                    27: 1,
                    13: 1
                }, Q = function(S) {
                    if (S.data.db() in P)
                        S.data.stopPropagation();
                };
                (function() {
                    p.dialog = {
                        bf: function(S, T, U, V, W, X, Y) {
                            if (arguments.length < 4)
                                return;
                            var Z = (V.call ? V(T) : V) || 'div',
                                    aa = ['<', Z, ' '],
                                    aT = (W && W.call ? W(T) : W) || {}, bm = (X && X.call ? X(T) : X) || {}, bW = (Y && Y.call ? Y(S, T) : Y) || '',
                                    eS = this.oJ = bm.id || k.getNextNumber() + '_uiElement',
                                    fv = this.id = T.id,
                                    aP;
                            bm.id = eS;
                            var bV = {};
                            if (T.type)
                                bV['cke_dialog_ui_' + T.type] = 1;
                            if (T.className)
                                bV[T.className] = 1;
                            var eN = bm['class'] && bm['class'].split ? bm['class'].split(' ') : [];
                            for (aP = 0; aP < eN.length; aP++) {
                                if (eN[aP])
                                    bV[eN[aP]] = 1;
                            }
                            var gB = [];
                            for (aP in bV)
                                gB.push(aP);
                            bm['class'] = gB.join(' ');
                            if (T.title)
                                bm.title = T.title;
                            var dX = (T.style || '').split(';');
                            for (aP in aT)
                                dX.push(aP + ':' + aT[aP]);
                            if (T.hidden)
                                dX.push('display:none');
                            for (aP = dX.length - 1; aP >= 0; aP--) {
                                if (dX[aP] === '')
                                    dX.splice(aP, 1);
                            }
                            if (dX.length > 0)
                                bm.style = (bm.style ? bm.style + '; ' : '') + dX.join('; ');
                            for (aP in bm)
                                aa.push(aP + '="' + k.htmlEncode(bm[aP]) + '" ');
                            aa.push('>', bW, '</', Z, '>');
                            U.push(aa.join(''));
                            (this._ || (this._ = {})).dialog = S;
                            if (typeof T.isChanged == 'boolean')
                                this.isChanged = function() {
                                    return T.isChanged;
                                };
                            if (typeof T.isChanged == 'function')
                                this.isChanged = T.isChanged;
                            a.event.du(this);
                            this.nc(T);
                            if (this.eZ && this.iU && T.accessKey)
                                L(this, S, 'bP+' + T.accessKey);
                            var gs = this;
                            S.on('load', function() {
                                if (gs.getInputElement())
                                    gs.getInputElement().on('focus', function() {
                                        S._.eC = false;
                                        S._.hasFocus = true;
                                        gs.oW('focus');
                                    }, gs);
                            });
                            if (this.eA) {
                                this.cQ = S._.eO.push(this) - 1;
                                this.on('focus', function() {
                                    S._.aW = gs.cQ;
                                });
                            }
                            k.extend(this, T);
                        },
                        hbox: function(S, T, U, V, W) {
                            if (arguments.length < 4)
                                return;
                            this._ || (this._ = {});
                            var X = this._.children = T,
                                    Y = W && W.widths || null,
                                    Z = W && W.height || null,
                                    aa = {}, aT, bm = function() {
                                var bW = ['<tbody><tr class="cke_dialog_ui_hbox">'];
                                for (aT = 0; aT < U.length; aT++) {
                                    var eS = 'cke_dialog_ui_hbox_child',
                                            fv = [];
                                    if (aT === 0)
                                        eS = 'cke_dialog_ui_hbox_first';
                                    if (aT == U.length - 1)
                                        eS = 'cke_dialog_ui_hbox_last';
                                    bW.push('<td class="', eS, '" ');
                                    if (Y) {
                                        if (Y[aT])
                                            fv.push('width:' + k.cssLength(Y[aT]));
                                    } else
                                        fv.push('width:' + Math.floor(100 / U.length) + '%');
                                    if (Z)
                                        fv.push('height:' + k.cssLength(Z));
                                    if (W && W.padding != undefined)
                                        fv.push('padding:' + k.cssLength(W.padding));
                                    if (fv.length > 0)
                                        bW.push('style="' + fv.join('; ') + '" ');
                                    bW.push('>', U[aT], '</td>');
                                }
                                bW.push('</tr></tbody>');
                                return bW.join('');
                            };
                            p.dialog.bf.call(this, S, W || {
                                type: 'hbox'
                            }, V, 'table', aa, W && W.align && {
                                align: W.align
                            } || null, bm);
                        },
                        vbox: function(S, T, U, V, W) {
                            if (arguments.length < 3)
                                return;
                            this._ || (this._ = {});
                            var X = this._.children = T,
                                    Y = W && W.width || null,
                                    Z = W && W.vY || null,
                                    aa = function() {
                                        var aT = ['<table cellspacing="0" border="0" '];
                                        aT.push('style="');
                                        if (W && W.expand)
                                            aT.push('height:100%;');
                                        aT.push('width:' + k.cssLength(Y || '100%'), ';');
                                        aT.push('"');
                                        aT.push('align="', k.htmlEncode(W && W.align || (S.eY().lang.dir == 'ltr' ? 'left' : 'right')), '" ');
                                        aT.push('><tbody>');
                                        for (var bm = 0; bm < U.length; bm++) {
                                            var bW = [];
                                            aT.push('<tr><td ');
                                            if (Y)
                                                bW.push('width:' + k.cssLength(Y || '100%'));
                                            if (Z)
                                                bW.push('height:' + k.cssLength(Z[bm]));
                                            else if (W && W.expand)
                                                bW.push('height:' + Math.floor(100 / U.length) + '%');
                                            if (W && W.padding != undefined)
                                                bW.push('padding:' + k.cssLength(W.padding));
                                            if (bW.length > 0)
                                                aT.push('style="', bW.join('; '), '" ');
                                            aT.push(' class="cke_dialog_ui_vbox_child">', U[bm], '</td></tr>');
                                        }
                                        aT.push('</tbody></table>');
                                        return aT.join('');
                                    };
                            p.dialog.bf.call(this, S, W || {
                                type: 'vbox'
                            }, V, 'div', null, null, aa);
                        }
                    };
                })();
                p.dialog.bf.prototype = {
                    getElement: function() {
                        return a.document.getById(this.oJ);
                    },
                    getInputElement: function() {
                        return this.getElement();
                    },
                    getDialog: function() {
                        return this._.dialog;
                    },
                    setValue: function(S) {
                        this.getInputElement().setValue(S);
                        this.oW('change', {
                            value: S
                        });
                        return this;
                    },
                    getValue: function() {
                        return this.getInputElement().getValue();
                    },
                    isChanged: function() {
                        return false;
                    },
                    selectParentTab: function() {
                        var V = this;
                        var S = V.getInputElement(),
                                T = S,
                                U;
                        while ((T = T.getParent()) && T.$.className.search('cke_dialog_page_contents') == -1) {
                        }
                        if (!T)
                            return V;
                        U = T.getAttribute('name');
                        if (V._.dialog._.gx != U)
                            V._.dialog.selectPage(U);
                        return V;
                    },
                    focus: function() {
                        this.selectParentTab().getInputElement().focus();
                        return this;
                    },
                    nc: function(S) {
                        var T = /^on([A-Z]\w+)/,
                                U, V = function(X, Y, Z, aa) {
                                    Y.on('load', function() {
                                        X.getInputElement().on(Z, aa, X);
                                    });
                                };
                        for (var W in S) {
                            if (!(U = W.match(T)))
                                continue;
                            if (this.dm[W])
                                this.dm[W].call(this, this._.dialog, S[W]);
                            else
                                V(this, this._.dialog, U[1].toLowerCase(), S[W]);
                        }
                        return this;
                    },
                    dm: {
                        onLoad: function(S, T) {
                            S.on('load', T, this);
                        },
                        onShow: function(S, T) {
                            S.on('show', T, this);
                        },
                        onHide: function(S, T) {
                            S.on('hide', T, this);
                        }
                    },
                    iU: function(S, T) {
                        this.focus();
                    },
                    eZ: function(S, T) {
                    },
                    disable: function() {
                        var S = this.getInputElement();
                        S.setAttribute('disabled', 'true');
                        S.addClass('cke_disabled');
                    },
                    enable: function() {
                        var S = this.getInputElement();
                        S.removeAttribute('disabled');
                        S.removeClass('cke_disabled');
                    },
                    isEnabled: function() {
                        return !this.getInputElement().getAttribute('disabled');
                    },
                    isVisible: function() {
                        return this.getInputElement().isVisible();
                    },
                    fM: function() {
                        if (!this.isEnabled() || !this.isVisible())
                            return false;
                        return true;
                    }
                };
                p.dialog.hbox.prototype = k.extend(new p.dialog.bf(), {
                    getChild: function(S) {
                        var T = this;
                        if (arguments.length < 1)
                            return T._.children.concat();
                        if (!S.splice)
                            S = [S];
                        if (S.length < 2)
                            return T._.children[S[0]];
                        else
                            return T._.children[S[0]] && T._.children[S[0]].getChild ? T._.children[S[0]].getChild(S.slice(1, S.length)) : null;
                    }
                }, true);
                p.dialog.vbox.prototype = new p.dialog.hbox();
                (function() {
                    var S = {
                        dQ: function(T, U, V) {
                            var W = U.children,
                                    X, Y = [],
                                    Z = [];
                            for (var aa = 0; aa < W.length && (X = W[aa]); aa++) {
                                var aT = [];
                                Y.push(aT);
                                Z.push(a.dialog._.gv[X.type].dQ(T, X, aT));
                            }
                            return new p.dialog[U.type](T, Z, Y, V, U);
                        }
                    };
                    a.dialog.addUIElement('hbox', S);
                    a.dialog.addUIElement('vbox', S);
                })();
                a.rB = function(S) {
                    this.ry = S;
                };
                a.rB.prototype = {
                    exec: function(S) {
                        S.openDialog(this.ry);
                    },
                    sG: false
                };
                (function() {
                    var S = /^([a]|[^a])+$/,
                            T = /^\d*$/,
                            U = /^\d*(?:\.\d+)?$/;
                    a.sg = 1;
                    a.jb = 2;
                    a.dialog.validate = {
                        functions: function() {
                            return function() {
                                var aT = this;
                                var V = aT && aT.getValue ? aT.getValue() : arguments[0],
                                        W = undefined,
                                        X = a.jb,
                                        Y = [],
                                        Z;
                                for (Z = 0; Z < arguments.length; Z++) {
                                    if (typeof arguments[Z] == 'function')
                                        Y.push(arguments[Z]);
                                    else
                                        break;
                                }
                                if (Z < arguments.length && typeof arguments[Z] == 'string') {
                                    W = arguments[Z];
                                    Z++;
                                }
                                if (Z < arguments.length && typeof arguments[Z] == 'number')
                                    X = arguments[Z];
                                var aa = X == a.jb ? true : false;
                                for (Z = 0; Z < Y.length; Z++) {
                                    if (X == a.jb)
                                        aa = aa && Y[Z](V);
                                    else
                                        aa = aa || Y[Z](V);
                                }
                                if (!aa) {
                                    if (W !== undefined)
                                        alert(W);
                                    if (aT && (aT.select || aT.focus))
                                        aT.select || aT.focus();
                                    return false;
                                }
                                return true;
                            };
                        },
                        regex: function(V, W) {
                            return function() {
                                var Y = this;
                                var X = Y && Y.getValue ? Y.getValue() : arguments[0];
                                if (!V.test(X)) {
                                    if (W !== undefined)
                                        alert(W);
                                    if (Y && (Y.select || Y.focus))
                                        if (Y.select)
                                            Y.select();
                                        else
                                            Y.focus();
                                    return false;
                                }
                                return true;
                            };
                        },
                        notEmpty: function(V) {
                            return this.regex(S, V);
                        },
                        integer: function(V) {
                            return this.regex(T, V);
                        },
                        number: function(V) {
                            return this.regex(U, V);
                        },
                        equals: function(V, W) {
                            return this.functions(function(X) {
                                return X == V;
                            }, W);
                        },
                        notEqual: function(V, W) {
                            return this.functions(function(X) {
                                return X != V;
                            }, W);
                        }
                    };
                })();

                function R(S, T) {
                    var U = function() {
                        W(this);
                        T(this);
                    }, V = function() {
                        W(this);
                    }, W = function(X) {
                        X.removeListener('ok', U);
                        X.removeListener('cancel', V);
                    };
                    S.on('ok', U);
                    S.on('cancel', V);
                }
                ;
                k.extend(a.application.prototype, {
                    openDialog: function(S, T, U) {
                        var V = a.dialog._.ev[S];
                        if (typeof V == 'function') {
                            var W = this._.oB || (this._.oB = {}),
                                    X = W[S] || (W[S] = new a.dialog(this, S));
                            T && T.call(X, X);
                            !this._.activeElement && (this._.activeElement = this.document.$.activeElement);
                            !this._.oO && (this._.oO = this.ld['filesview.filesview'].tools.oO());
                            X.show();
                            return X;
                        } else if (V == 'failed')
                            throw new Error('[CKFINDER.dialog.openDialog] Dialog "' + S + '" failed when loading dg.');
                        var Y = a.document.bH(),
                                Z = Y.$.style.cursor,
                                aa = this;
                        Y.setStyle('cursor', 'wait');
                        a.scriptLoader.load(a.getUrl(V), function() {
                            if (typeof a.dialog._.ev[S] != 'function')
                                a.dialog._.ev[S] = 'failed';
                            aa.openDialog(S, T);
                            Y.setStyle('cursor', Z);
                        }, null, null, U);
                        return null;
                    },
                    hs: function(S, T, U, V) {
                        var W = this;
                        setTimeout(function() {
                            W.cg.openDialog('Input', function(X) {
                                X.show();
                                X.setTitle(S || W.lang.common.inputTitle);
                                X.getContentElement('tab1', 'msg').getElement().setHtml(T);
                                X.getContentElement('tab1', 'input').setValue(U);
                                R(X, function(Y) {
                                    var Z = Y.getContentElement('tab1', 'input').getValue();
                                    V(Z);
                                });
                            });
                        }, 0);
                    },
                    msgDialog: function(S, T, U) {
                        var V = this;
                        setTimeout(function() {
                            V.cg.openDialog('Msg', function(W) {
                                W.show();
                                W.setTitle(S || V.lang.common.messageTitle);
                                W.getContentElement('tab1', 'msg').getElement().setHtml(T);
                                U && R(W, function(X) {
                                    U();
                                });
                            });
                        }, 0);
                    },
                    fe: function(S, T, U) {
                        var V = this;
                        setTimeout(function() {
                            V.cg.openDialog('Confirm', function(W) {
                                W.show();
                                W.setTitle(S || V.lang.common.confirmationTitle);
                                W.getContentElement('tab1', 'msg').getElement().setHtml(T);
                                R(W, function(X) {
                                    U();
                                });
                            });
                        }, 0);
                    },
                    skippedFilesDialog: function(S, T, U, V) {
                        var W = this;
                        setTimeout(function() {
                            W.cg.openDialog('SkippedFiles', function(X) {
                                X.show();
                                X.setTitle(S || W.lang.common.messageTitle);
                                if (U) {
                                    X.getContentElement('tab1', 'msg').getElement().show();
                                    X.getContentElement('tab1', 'msg').getElement().setHtml(U);
                                } else
                                    X.getContentElement('tab1', 'msg').getElement().hide();
                                var Y = '',
                                        Z = 'cke_files_list',
                                        aa = '',
                                        aT = T.length;
                                if (aT > 3) {
                                    Z += ' cke_files_list_many';
                                    aa = ' style="height: ' + Math.min(aT + 0.1, 20) + 'em"';
                                }
                                for (var bm = 0; bm < aT; bm++)
                                    Y += '<li>' + (typeof T[bm] == 'string' ? T[bm] : T[bm].getAttribute('name')) + '</li>';
                                X.getContentElement('tab1', 'skippedList').getElement().setHtml('<ul class="' + Z + '"' + aa + '>' + Y + '</ul>');
                                V && R(X, function() {
                                    V();
                                });
                            });
                        }, 0);
                    }
                });
                o.add('dialog', {
                    bM: ['dialogui'],
                    onLoad: function() {
                        a.dialog.add('Confirm', function(S) {
                            return {
                                title: S.lang.common.confirmationTitle,
                                minWidth: 270,
                                minHeight: 60,
                                contents: [{
                                        id: 'tab1',
                                        elements: [{
                                                type: 'html',
                                                html: '',
                                                id: 'msg'
                                            }]
                                    }],
                                buttons: [CKFinder.dialog.okButton, CKFinder.dialog.cancelButton]
                            };
                        });
                        a.dialog.add('Msg', function(S) {
                            return {
                                title: S.lang.common.messageTitle,
                                minWidth: 270,
                                minHeight: 60,
                                contents: [{
                                        id: 'tab1',
                                        elements: [{
                                                type: 'html',
                                                html: '',
                                                id: 'msg'
                                            }]
                                    }],
                                buttons: [CKFinder.dialog.okButton]
                            };
                        });
                        a.dialog.add('Input', function(S) {
                            return {
                                title: S.lang.common.inputTitle,
                                minWidth: 270,
                                minHeight: 60,
                                contents: [{
                                        id: 'tab1',
                                        elements: [{
                                                type: 'html',
                                                html: '',
                                                id: 'msg'
                                            }, {
                                                type: 'text',
                                                id: 'input'
                                            }]
                                    }],
                                buttons: [CKFinder.dialog.okButton, CKFinder.dialog.cancelButton]
                            };
                        });
                        a.dialog.add('SkippedFiles', function(S) {
                            return {
                                title: S.lang.common.messageTitle,
                                minWidth: 400,
                                minHeight: 100,
                                contents: [{
                                        id: 'tab1',
                                        style: h.ie7Compat ? 'height: auto' : '',
                                        expand: true,
                                        padding: 0,
                                        elements: [{
                                                type: 'vbox',
                                                expand: true,
                                                children: [{
                                                        type: 'html',
                                                        className: 'cke_dialog_msg',
                                                        html: '',
                                                        id: 'msg'
                                                    }, {
                                                        type: 'html',
                                                        id: 'skippedDescription',
                                                        className: 'cke_dialog_msg',
                                                        html: S.lang.SkippedFiles
                                                    }, {
                                                        type: 'html',
                                                        id: 'skippedList',
                                                        className: 'cke_dialog_msg',
                                                        html: ''
                                                    }]
                                            }]
                                    }],
                                buttons: [CKFinder.dialog.okButton]
                            };
                        });
                    }
                });
            })();
            o.add('dialogui');
            (function() {
                var r = function(y) {
                    var B = this;
                    B._ || (B._ = {});
                    B._['default'] = B._.hq = y['default'] || '';
                    var z = [B._];
                    for (var A = 1; A < arguments.length; A++)
                        z.push(arguments[A]);
                    z.push(true);
                    k.extend.apply(k, z);
                    return B._;
                }, s = {
                    dQ: function(y, z, A) {
                        return new p.dialog.ju(y, z, A);
                    }
                }, t = {
                    dQ: function(y, z, A) {
                        return new p.dialog[z.type](y, z, A);
                    }
                }, u = {
                    isChanged: function() {
                        return this.getValue() != this.lu();
                    },
                    reset: function() {
                        this.setValue(this.lu());
                    },
                    jW: function() {
                        this._.hq = this.getValue();
                    },
                    ki: function() {
                        this._.hq = this._['default'];
                    },
                    lu: function() {
                        return this._.hq;
                    }
                }, v = k.extend({}, p.dialog.bf.prototype.dm, {
                    onChange: function(y, z) {
                        if (!this._.pL) {
                            y.on('load', function() {
                                this.getInputElement().on('change', function() {
                                    this.oW('change', {
                                        value: this.getValue()
                                    });
                                }, this);
                            }, this);
                            this._.pL = true;
                        }
                        this.on('change', z);
                    }
                }, true),
                        w = /^on([A-Z]\w+)/,
                        x = function(y) {
                            for (var z in y) {
                                if (w.test(z) || z == 'title' || z == 'type')
                                    delete y[z];
                            }
                            return y;
                        };
                k.extend(p.dialog, {
                    dD: function(y, z, A, B) {
                        if (arguments.length < 4)
                            return;
                        var C = r.call(this, z);
                        C.hz = k.getNextNumber() + '_label';
                        var D = this._.children = [],
                                E = function() {
                                    var F = [];
                                    if (z.uC != 'horizontal')
                                        F.push('<div class="cke_dialog_ui_labeled_label" id="', C.hz, '" >', z.label, '</div>', '<div class="cke_dialog_ui_labeled_content">', B(y, z), '</div>');
                                    else {
                                        var G = {
                                            type: 'hbox',
                                            widths: z.widths,
                                            padding: 0,
                                            children: [{
                                                    type: 'html',
                                                    html: '<span class="cke_dialog_ui_labeled_label" id="' + C.hz + '">' + k.htmlEncode(z.label) + '</span>'
                                                }, {
                                                    type: 'html',
                                                    html: '<span class="cke_dialog_ui_labeled_content">' + B(y, z) + '</span>'
                                                }]
                                        };
                                        a.dialog._.gv.hbox.dQ(y, G, F);
                                    }
                                    return F.join('');
                                };
                        p.dialog.bf.call(this, y, z, A, 'div', null, null, E);
                    },
                    ju: function(y, z, A) {
                        if (arguments.length < 3)
                            return;
                        r.call(this, z);
                        var B = this._.le = k.getNextNumber() + '_textInput',
                                C = {
                                    'class': 'cke_dialog_ui_input_' + z.type,
                                    id: B,
                                    type: 'text'
                                }, D;
                        if (z.validate)
                            this.validate = z.validate;
                        if (z.maxLength)
                            C.uy = z.maxLength;
                        if (z.size)
                            C.size = z.size;
                        var E = this,
                                F = false;
                        y.on('load', function() {
                            E.getInputElement().on('keydown', function(H) {
                                if (H.data.db() == 13)
                                    F = true;
                            });
                            E.getInputElement().on('keyup', function(H) {
                                if (H.data.db() == 13 && F) {
                                    y.getButton('ok') && setTimeout(function() {
                                        y.getButton('ok').click();
                                    }, 0);
                                    F = false;
                                }
                            }, null, null, 1000);
                        });
                        var G = function() {
                            var H = ['<div class="cke_dialog_ui_input_', z.type, '"'];
                            if (z.width)
                                H.push('style="width:' + z.width + '" ');
                            H.push('><input ');
                            for (var I in C)
                                H.push(I + '="' + C[I] + '" ');
                            H.push(' /></div>');
                            return H.join('');
                        };
                        p.dialog.dD.call(this, y, z, A, G);
                    },
                    textarea: function(y, z, A) {
                        if (arguments.length < 3)
                            return;
                        r.call(this, z);
                        var B = this,
                                C = this._.le = k.getNextNumber() + '_textarea',
                                D = {};
                        if (z.validate)
                            this.validate = z.validate;
                        D.rows = z.rows || 5;
                        D.cols = z.cols || 20;
                        var E = function() {
                            var F = ['<div class="cke_dialog_ui_input_textarea"><textarea class="cke_dialog_ui_input_textarea" id="', C, '" '];
                            for (var G in D)
                                F.push(G + '="' + k.htmlEncode(D[G]) + '" ');
                            F.push('>', k.htmlEncode(B._['default']), '</textarea></div>');
                            return F.join('');
                        };
                        p.dialog.dD.call(this, y, z, A, E);
                    },
                    checkbox: function(y, z, A) {
                        if (arguments.length < 3)
                            return;
                        var B = r.call(this, z, {
                            'default': !!z['default']
                        });
                        if (z.validate)
                            this.validate = z.validate;
                        var C = function() {
                            var D = k.extend({}, z, {
                                id: z.id ? z.id + '_checkbox' : k.getNextNumber() + '_checkbox'
                            }, true),
                                    E = [],
                                    F = {
                                        'class': 'cke_dialog_ui_checkbox_input',
                                        type: 'checkbox'
                                    };
                            x(D);
                            if (z['default'])
                                F.checked = 'checked';
                            B.checkbox = new p.dialog.bf(y, D, E, 'input', null, F);
                            E.push(' <label for="', F.id, '">', k.htmlEncode(z.label), '</label>');
                            return E.join('');
                        };
                        p.dialog.bf.call(this, y, z, A, 'span', null, null, C);
                    },
                    radio: function(y, z, A) {
                        if (arguments.length < 3)
                            return;
                        r.call(this, z);
                        if (!this._['default'])
                            this._['default'] = this._.hq = z.items[0][1];
                        if (z.validate)
                            this.validate = z.sh;
                        var B = [],
                                C = this,
                                D = function() {
                                    var E = [],
                                            F = [],
                                            G = {
                                                'class': 'cke_dialog_ui_radio_item'
                                            }, H = z.id ? z.id + '_radio' : k.getNextNumber() + '_radio';
                                    for (var I = 0; I < z.items.length; I++) {
                                        var J = z.items[I],
                                                K = J[2] !== undefined ? J[2] : J[0],
                                                L = J[1] !== undefined ? J[1] : J[0],
                                                M = k.extend({}, z, {
                                                    id: k.getNextNumber() + '_radio_input',
                                                    title: null,
                                                    type: null
                                                }, true),
                                                N = k.extend({}, M, {
                                                    id: null,
                                                    title: K
                                                }, true),
                                                O = {
                                                    type: 'radio',
                                                    'class': 'cke_dialog_ui_radio_input',
                                                    name: H,
                                                    value: L
                                                }, P = [];
                                        if (C._['default'] == L)
                                            O.checked = 'checked';
                                        x(M);
                                        x(N);
                                        B.push(new p.dialog.bf(y, M, P, 'input', null, O));
                                        P.push(' ');
                                        new p.dialog.bf(y, N, P, 'label', null, {
                                            'for': O.id
                                        }, J[0]);
                                        E.push(P.join(''));
                                    }
                                    new p.dialog.hbox(y, [], E, F);
                                    return F.join('');
                                };
                        p.dialog.dD.call(this, y, z, A, D);
                        this._.children = B;
                    },
                    button: function(y, z, A) {
                        if (!arguments.length)
                            return;
                        if (typeof z == 'function')
                            z = z(y.eY());
                        r.call(this, z, {
                            disabled: z.disabled || false
                        });
                        a.event.du(this);
                        var B = this;
                        y.on('load', function(D) {
                            var E = this.getElement();
                            (function() {
                                E.on('click', function(F) {
                                    B.oW('click', {
                                        dialog: B.getDialog()
                                    });
                                    F.data.preventDefault();
                                });
                            })();
                            E.unselectable();
                        }, this);
                        var C = k.extend({}, z);
                        delete C.style;
                        p.dialog.bf.call(this, y, C, A, 'a', null, {
                            style: z.style,
                            href: 'javascript:void(0)',
                            title: z.label,
                            hp: 'true',
                            'class': z['class']
                        }, '<span class="cke_dialog_ui_button">' + k.htmlEncode(z.label) + '</span>');
                    },
                    select: function(y, z, A) {
                        if (arguments.length < 3)
                            return;
                        var B = r.call(this, z);
                        if (z.validate)
                            this.validate = z.validate;
                        var C = function() {
                            var D = k.extend({}, z, {
                                id: z.id ? z.id + '_select' : k.getNextNumber() + '_select'
                            }, true),
                                    E = [],
                                    F = [],
                                    G = {
                                        'class': 'cke_dialog_ui_input_select'
                                    };
                            if (z.size != undefined)
                                G.size = z.size;
                            if (z.multiple != undefined)
                                G.multiple = z.multiple;
                            x(D);
                            for (var H = 0, I; H < z.items.length && (I = z.items[H]); H++)
                                F.push('<option value="', k.htmlEncode(I[1] !== undefined ? I[1] : I[0]), '" /> ', k.htmlEncode(I[0]));
                            B.select = new p.dialog.bf(y, D, E, 'select', null, G, F.join(''));
                            return E.join('');
                        };
                        p.dialog.dD.call(this, y, z, A, C);
                    },
                    file: function(y, z, A) {
                        if (arguments.length < 3)
                            return;
                        if (z['default'] === undefined)
                            z['default'] = '';
                        var B = k.extend(r.call(this, z), {
                            dg: z,
                            buttons: []
                        });
                        if (z.validate)
                            this.validate = z.validate;
                        var C = function() {
                            B.gL = k.getNextNumber() + '_fileInput';
                            var D = h.isCustomDomain(),
                                    E = ['<iframe frameborder="0" allowtransparency="0" class="cke_dialog_ui_input_file" id="', B.gL, '" title="', z.label, '" src="javascript:void('];
                            E.push(D ? "(function(){document.open();document.domain='" + document.domain + "';" + 'document.close();' + '})()' : '0');
                            E.push(')"></iframe>');
                            return E.join('');
                        };
                        y.on('load', function() {
                            var D = a.document.getById(B.gL),
                                    E = D.getParent();
                            E.addClass('cke_dialog_ui_input_file');
                        });
                        p.dialog.dD.call(this, y, z, A, C);
                    },
                    fileButton: function(y, z, A) {
                        if (arguments.length < 3)
                            return;
                        var B = r.call(this, z),
                                C = this;
                        if (z.validate)
                            this.validate = z.validate;
                        var D = k.extend({}, z),
                                E = D.onClick;
                        D.className = (D.className ? D.className + ' ' : '') + 'cke_dialog_ui_button';
                        D.onClick = function(F) {
                            var G = z['for'];
                            if (!E || E.call(this, F) !== false) {
                                y.getContentElement(G[0], G[1]).submit();
                                this.disable();
                            }
                        };
                        y.on('load', function() {
                            y.getContentElement(z['for'][0], z['for'][1])._.buttons.push(C);
                        });
                        p.dialog.button.call(this, y, D, A);
                    },
                    html: (function() {
                        var y = /^\s*<[\w:]+\s+([^>]*)?>/,
                                z = /^(\s*<[\w:]+(?:\s+[^>]*)?)((?:.|\r|\n)+)$/,
                                A = /\/$/;
                        return function(B, C, D) {
                            if (arguments.length < 3)
                                return;
                            var E = [],
                                    F, G = C.html,
                                    H, I;
                            if (G.charAt(0) != '<')
                                G = '<span>' + G + '</span>';
                            if (C.focus) {
                                var J = this.focus;
                                this.focus = function() {
                                    J.call(this);
                                    C.focus.call(this);
                                    this.oW('focus');
                                };
                                if (C.fM) {
                                    var K = this.fM;
                                    this.fM = K;
                                }
                                this.eA = true;
                            }
                            p.dialog.bf.call(this, B, C, E, 'span', null, null, '');
                            F = E.join('');
                            H = F.match(y);
                            I = G.match(z) || ['', '', ''];
                            if (A.test(I[1])) {
                                I[1] = I[1].slice(0, -1);
                                I[2] = '/' + I[2];
                            }
                            D.push([I[1], ' ', H[1] || '', I[2]].join(''));
                        };
                    })()
                }, true);
                p.dialog.html.prototype = new p.dialog.bf();
                p.dialog.dD.prototype = k.extend(new p.dialog.bf(), {
                    rW: function(y) {
                        var z = a.document.getById(this._.hz);
                        if (z.iu() < 1)
                            new j.text(y, a.document).appendTo(z);
                        else
                            z.getChild(0).$.nodeValue = y;
                        return this;
                    },
                    vt: function() {
                        var y = a.document.getById(this._.hz);
                        if (!y || y.iu() < 1)
                            return '';
                        else
                            return y.getChild(0).getText();
                    },
                    dm: v
                }, true);
                p.dialog.button.prototype = k.extend(new p.dialog.bf(), {
                    click: function() {
                        var y = this;
                        if (!y._.disabled)
                            return y.oW('click', {
                                dialog: y._.dialog
                            });
                        y.getElement().$.blur();
                        return false;
                    },
                    enable: function() {
                        this._.disabled = false;
                        var y = this.getElement();
                        y && y.removeClass('disabled');
                    },
                    disable: function() {
                        this._.disabled = true;
                        this.getElement().addClass('disabled');
                    },
                    isVisible: function() {
                        return this.getElement().getFirst().isVisible();
                    },
                    isEnabled: function() {
                        return !this._.disabled;
                    },
                    dm: k.extend({}, p.dialog.bf.prototype.dm, {
                        onClick: function(y, z) {
                            this.on('click', z);
                        }
                    }, true),
                    eZ: function() {
                        this.click();
                    },
                    iU: function() {
                        this.focus();
                    },
                    eA: true
                }, true);
                p.dialog.ju.prototype = k.extend(new p.dialog.dD(), {
                    getInputElement: function() {
                        return a.document.getById(this._.le);
                    },
                    focus: function() {
                        var y = this.selectParentTab();
                        setTimeout(function() {
                            var z = y.getInputElement();
                            z && z.$.focus();
                        }, 0);
                    },
                    select: function() {
                        var y = this.selectParentTab();
                        setTimeout(function() {
                            var z = y.getInputElement();
                            if (z) {
                                z.$.focus();
                                z.$.select();
                            }
                        }, 0);
                    },
                    eZ: function() {
                        this.select();
                    },
                    setValue: function(y) {
                        y = y !== null ? y : '';
                        return p.dialog.bf.prototype.setValue.call(this, y);
                    },
                    eA: true
                }, u, true);
                p.dialog.textarea.prototype = new p.dialog.ju();
                p.dialog.select.prototype = k.extend(new p.dialog.dD(), {
                    getInputElement: function() {
                        return this._.select.getElement();
                    },
                    add: function(y, z, A) {
                        var B = new m('option', this.getDialog().eY().document),
                                C = this.getInputElement().$;
                        B.$.text = y;
                        B.$.value = z === undefined || z === null ? y : z;
                        if (A === undefined || A === null) {
                            if (i)
                                C.add(B.$);
                            else
                                C.add(B.$, null);
                        } else
                            C.add(B.$, A);
                        return this;
                    },
                    remove: function(y) {
                        var z = this.getInputElement().$;
                        z.remove(y);
                        return this;
                    },
                    clear: function() {
                        var y = this.getInputElement().$;
                        while (y.length > 0)
                            y.remove(0);
                        return this;
                    },
                    eA: true
                }, u, true);
                p.dialog.checkbox.prototype = k.extend(new p.dialog.bf(), {
                    getInputElement: function() {
                        return this._.checkbox.getElement();
                    },
                    setValue: function(y) {
                        this.getInputElement().$.checked = y;
                        this.oW('change', {
                            value: y
                        });
                    },
                    getValue: function() {
                        return this.getInputElement().$.checked;
                    },
                    eZ: function() {
                        this.setValue(!this.getValue());
                    },
                    dm: {
                        onChange: function(y, z) {
                            if (!i)
                                return v.onChange.apply(this, arguments);
                            else {
                                y.on('load', function() {
                                    var A = this._.checkbox.getElement();
                                    A.on('propertychange', function(B) {
                                        B = B.data.$;
                                        if (B.propertyName == 'checked')
                                            this.oW('change', {
                                                value: A.$.checked
                                            });
                                    }, this);
                                }, this);
                                this.on('change', z);
                            }
                            return null;
                        }
                    },
                    eA: true
                }, u, true);
                p.dialog.radio.prototype = k.extend(new p.dialog.bf(), {
                    setValue: function(y) {
                        var z = this._.children,
                                A;
                        for (var B = 0; B < z.length && (A = z[B]); B++)
                            A.getElement().$.checked = A.getValue() == y;
                        this.oW('change', {
                            value: y
                        });
                    },
                    getValue: function() {
                        var y = this._.children;
                        for (var z = 0; z < y.length; z++) {
                            if (y[z].getElement().$.checked)
                                return y[z].getValue();
                        }
                        return null;
                    },
                    eZ: function() {
                        var y = this._.children,
                                z;
                        for (z = 0; z < y.length; z++) {
                            if (y[z].getElement().$.checked) {
                                y[z].getElement().focus();
                                return;
                            }
                        }
                        y[0].getElement().focus();
                    },
                    dm: {
                        onChange: function(y, z) {
                            if (!i)
                                return v.onChange.apply(this, arguments);
                            else {
                                y.on('load', function() {
                                    var A = this._.children,
                                            B = this;
                                    for (var C = 0; C < A.length; C++) {
                                        var D = A[C].getElement();
                                        D.on('propertychange', function(E) {
                                            E = E.data.$;
                                            if (E.propertyName == 'checked' && this.$.checked)
                                                B.oW('change', {
                                                    value: this.getAttribute('value')
                                                });
                                        });
                                    }
                                }, this);
                                this.on('change', z);
                            }
                            return null;
                        }
                    },
                    eA: true
                }, u, true);
                p.dialog.file.prototype = k.extend(new p.dialog.dD(), u, {
                    getInputElement: function() {
                        var y = a.document.getById(this._.gL).getFrameDocument();
                        return y.$.forms.length > 0 ? new m(y.$.forms[0].elements[0]) : this.getElement();
                    },
                    submit: function() {
                        this.getInputElement().getParent().$.submit();
                        return this;
                    },
                    vy: function(y) {
                        return this.getInputElement().getParent().$.action;
                    },
                    reset: function() {
                        var y = a.document.getById(this._.gL),
                                z = y.getFrameDocument(),
                                A = this._.dg,
                                B = this._.buttons;

                        function C() {
                            z.$.open();
                            if (h.isCustomDomain())
                                z.$.domain = document.domain;
                            var D = '';
                            if (A.size)
                                D = A.size - (i ? 7 : 0);
                            z.$.write(['<html><head><title></title></head><body style="margin: 0; overflow: hidden; background: transparent;">', '<form enctype="multipart/form-data" method="POST" action="', k.htmlEncode(A.action), '">', '<input type="file" name="', k.htmlEncode(A.id || 'cke_upload'), '" size="', k.htmlEncode(D > 0 ? D : ''), '" />', '</form>', '</body></html>'].join(''));
                            z.$.close();
                            for (var E = 0; E < B.length; E++)
                                B[E].enable();
                        }
                        ;
                        if (h.gecko)
                            setTimeout(C, 500);
                        else
                            C();
                    },
                    getValue: function() {
                        return '';
                    },
                    dm: v,
                    eA: true
                }, true);
                p.dialog.fileButton.prototype = new p.dialog.button();
                a.dialog.addUIElement('text', s);
                a.dialog.addUIElement('password', s);
                a.dialog.addUIElement('textarea', t);
                a.dialog.addUIElement('checkbox', t);
                a.dialog.addUIElement('radio', t);
                a.dialog.addUIElement('button', t);
                a.dialog.addUIElement('select', t);
                a.dialog.addUIElement('file', t);
                a.dialog.addUIElement('fileButton', t);
                a.dialog.addUIElement('html', t);
                k.extend(CKFinder.dialog, a.dialog);
            })();
            (function() {
                o.add('help', {
                    bM: ['toolbar', 'button'],
                    bz: function s(r) {
                        if (!r.config.disableHelpButton) {
                            r.bD('help', {
                                exec: function(t) {
                                    t.ld['filesview.filesview'].bn().focus();
                                    window.open(a.basePath + 'help/' + (t.lang.HelpLang || 'en') + '/index.html');
                                }
                            });
                            r.bY.add('Help', a.UI_BUTTON, {
                                label: r.lang.Help,
                                command: 'help'
                            });
                        }
                    }
                });
            })();
            (function() {
                var r = 1,
                        s = 2,
                        t = 3,
                        u = 4,
                        v = 5,
                        w = 0,
                        x = 0,
                        y = [],
                        z, A;

                function B(J, K, L, M, N) {
                    var O = 0,
                            P = 0,
                            Q = [];
                    for (var R = 0; R < J.length; R++) {
                        if (!M || M(J[R])) {
                            Q.push('<a href="', K.folder.getUrl(), encodeURIComponent(J[R].name), '" title="', J[R].name, '" rel="', L, '">a</a>');
                            if (J[R].isSameFile(K))
                                O = P;
                            P++;
                        }
                    }
                    E();
                    A = new m('div', N);
                    A.setAttribute('id', 'ckf_gallery');
                    A.setHtml(Q.join(''));
                    A.appendTo(N.bH());
                    A.hide();
                    return O;
                }
                ;

                function C(J) {
                    if (J && J.inPopup) {
                        var K = new l(J.document),
                                L = K.getWindow();
                        if (!i && !h.opera || L.$.top.location.href.match(/ckfinder.html/) || L.$.top.name == 'CKFinderpopup')
                            return K;
                    }
                    return a.oC;
                }
                ;

                function D(J) {
                    return function() {
                        J.$.activeElement && J.$.activeElement.blur();
                        J.$.activeElement && J.$.activeElement.blur();
                        if (!h.gecko) {
                            J.getWindow().focus();
                            J.bH().focus();
                        }
                    };
                }
                ;

                function E() {
                    A && A.remove();
                }
                ;

                function F(J) {
                    return function() {
                        E();
                        J && J.focus(true, true);
                    };
                }
                ;

                function G(J) {
                    if (J.click)
                        J.click();
                    else if (a.document.$.createEvent) {
                        var K = a.document.$.createEvent('MouseEvents');
                        K.initEvent('click', true, true);
                        J.dispatchEvent(K);
                    }
                }
                ;

                function H(J, K, L) {
                    if (i && h.version < 9)
                        J.$.onreadystatechange = function() {
                            if (this.readyState == 'loaded' || this.readyState == 'complete')
                                setTimeout(function() {
                                    K.callee.apply(L, K);
                                }, 0);
                        };
                    else
                        J.on('load', function() {
                            setTimeout(function() {
                                K.callee.apply(L, K);
                            }, 0);
                        });
                }
                ;
                CKFinder.addPlugin('gallery', {
                    bM: ['filesview'],
                    galleryCallback: function(J, K, L) {
                        if (!x)
                            I(null, J);
                        var M = C(J),
                                N = M.getWindow().$,
                                O = function(aT) {
                                    return aT.isImage();
                                };
                        if (!w && J.config.gallery_autoLoad) {
                            if (!O(K))
                                return false;
                            var P = M.getHead(),
                                    Q = CKFinder.getPluginPath('gallery') + 'colorbox/',
                                    R = arguments,
                                    S, T = typeof N.jQuery == 'undefined';
                            if (!T) {
                                var U = N.jQuery.fn.jquery.split('.'),
                                        V = parseInt(U[0], 10),
                                        W = parseInt(U[1], 10),
                                        X = parseInt(U[2] || 0, 10);
                                if (V < 1 || V == 1 && W < 4 || V == 1 && W == 4 && X < 3)
                                    T = true;
                            }
                            if (T) {
                                if (N.jQuery)
                                    y = [N.jQuery, N.$];
                                S = new m('script', M);
                                S.setAttribute('type', 'text/javascript');
                                S.setAttribute('src', Q + 'jquery.min.js');
                                H(S, R, N);
                                S.appendTo(P);
                                return true;
                            }
                            M.appendStyleSheet(Q + 'colorbox.css');
                            S = new m('script', M);
                            S.setAttribute('type', 'text/javascript');
                            S.setAttribute('src', Q + 'jquery.colorbox-min.js');
                            H(S, R, N);
                            S.appendTo(P);
                            return true;
                        }
                        if (y.length) {
                            z = N.jQuery.noConflict(true);
                            N.jQuery = y[0];
                            N.$ = y[1];
                            y = [];
                        }
                        if (!z)
                            z = N.jQuery;
                        if (w) {
                            var Y = k.getNextNumber(),
                                    Z, aa = 'ckf_gallery_' + Y;
                            switch (w) {
                                case r:
                                    if (!O(K))
                                        return false;
                                    Z = B(L, K, aa, O, M);
                                    z('#ckf_gallery a').colorbox(k.extend({
                                        minWidth: '300',
                                        minHeight: '200',
                                        maxWidth: '95%',
                                        maxHeight: '95%',
                                        scalePhotos: true,
                                        current: J.lang.Gallery.current
                                    }, J.config.gallery_config, {
                                        rel: aa,
                                        group: aa,
                                        onClosed: F(K),
                                        onOpen: D(M)
                                    }, true)).eq(Z).click();
                                    break;
                                case s:
                                    O = function(aT) {
                                        return aT.isImage() || aT.ext == 'swf';
                                    };
                                    if (!O(K))
                                        return false;
                                    Z = B(L, K, aa, O, M);
                                    N.jQuery('#ckf_gallery a').fancybox(k.extend({}, J.config.gallery_config, {
                                        onClosed: E,
                                        onComplete: D(M),
                                        afterClose: F(K),
                                        afterShow: D(M)
                                    }, true)).eq(Z).click();
                                    break;
                                case t:
                                    O = function(aT) {
                                        return aT.isImage() || aT.ext == 'swf' || aT.ext == 'mov';
                                    };
                                    if (!O(K))
                                        return false;
                                    Z = B(L, K, 'prettyPhoto[ckf_gallery_' + Y + ']', O, M);
                                    N.jQuery('#ckf_gallery a').prettyPhoto(k.extend({}, J.config.gallery_config, {
                                        callback: F(K),
                                        changepicturecallback: D(M)
                                    }, true)).eq(Z).click();
                                    break;
                                case u:
                                    O = function(aT) {
                                        return aT.isImage() || aT.ext == 'swf' || aT.ext == 'mov';
                                    };
                                    if (!O(K))
                                        return false;
                                    Z = B(L, K, aa, O, M);
                                    N.Shadowbox.qi('#ckf_gallery a', k.extend({}, J.config.gallery_config, {
                                        gallery: aa,
                                        onClose: F(K),
                                        onFinish: D(M)
                                    }, true));
                                    G(A.eG('a').getItem(Z).$);
                                    break;
                                case v:
                                    if (!O(K))
                                        return false;
                                    Z = B(L, K, 'lightbox[ckf_gallery_' + Y + ']', O, M);
                                    G(A.eG('a').getItem(Z).$);
                                    break;
                                default:
                                    return false;
                            }
                            return true;
                        }
                        return false;
                    },
                    bz: I
                });

                function I(J, K) {
                    if (J && J.inPopup)
                        return;
                    J && J.ld['filesview.filesview'].on('afterRenderFiles', E);
                    var L = C(K).getWindow().$;
                    if (typeof L.jQuery != 'undefined' && L.jQuery.fn.colorbox)
                        w = r;
                    else if (typeof L.jQuery != 'undefined' && L.jQuery.fn.fancybox)
                        w = s;
                    else if (typeof L.jQuery != 'undefined' && L.jQuery.fn.prettyPhoto)
                        w = t;
                    else if (typeof L.Shadowbox != 'undefined')
                        w = u;
                    else if (typeof L.Prototype != 'undefined' && typeof L.Lightbox != 'undefined')
                        w = v;
                    w && (x = 1);
                }
                ;
            })();
            n.gallery_autoLoad = true;
            (function() {
                function r(x) {
                    if (!x || x.type != a.cv || x.getName() != 'form')
                        return [];
                    var y = [],
                            z = ['style', 'className'];
                    for (var A = 0; A < z.length; A++) {
                        var B = z[A],
                                C = x.$.elements.namedItem(B);
                        if (C) {
                            var D = new m(C);
                            y.push([D, D.nextSibling]);
                            D.remove();
                        }
                    }
                    return y;
                }
                ;

                function s(x, y) {
                    if (!x || x.type != a.cv || x.getName() != 'form')
                        return;
                    if (y.length > 0)
                        for (var z = y.length - 1; z >= 0; z--) {
                            var A = y[z][0],
                                    B = y[z][1];
                            if (B)
                                A.insertBefore(B);
                            else
                                A.appendTo(x);
                        }
                }
                ;

                function t(x, y) {
                    var z = r(x),
                            A = {}, B = x.$;
                    if (!y) {
                        A['class'] = B.className || '';
                        B.className = '';
                    }
                    A.inline = B.style.cssText || '';
                    if (!y)
                        B.style.cssText = 'position: static; overflow: visible';
                    s(z);
                    return A;
                }
                ;

                function u(x, y) {
                    var z = r(x),
                            A = x.$;
                    if ('class' in y)
                        A.className = y['class'];
                    if ('inline' in y)
                        A.style.cssText = y.inline;
                    s(z);
                }
                ;
                var v = null,
                        w = null;
                o.add('maximize', {
                    bz: function(x) {
                        var y = x.lang.Maximize,
                                z = a.oC,
                                A = z.getWindow(),
                                B, C = [0, 0, 0, 0],
                                D = {}, E, F;
                        B = a.document.getWindow().$;
                        try {
                            B = B.frameElement;
                        } catch (H) {
                            B = null;
                        }
                        B = B && new m(B);
                        if (B && !B.getFrameDocument().bH().hasClass('CKFinderFrameWindow'))
                            B = null;

                        function G(I) {
                            var J = A.eR();
                            if (!I && B)
                                I = [B];
                            if (I) {
                                for (var K = 0, L = I.length; K < L; K++)
                                    I[K].setStyles({
                                        width: J.width + 'px',
                                        height: J.height + 'px'
                                    });
                                x.oW('resize');
                            } else
                                x.resize(J.width, J.height);
                        }
                        ;
                        x.bD('maximize', {
                            oD: false,
                            exec: function() {
                                var I = x.document.getWindow().$;
                                if (x.cg.inPopup && (!i && !h.opera || I.top.location.href.match(/ckfinder.html/) || I.top.name == 'CKFinderpopup')) {
                                    var I = x.document.getWindow().$.parent;
                                    if (this.bu == a.aS) {
                                        C[2] = I.screenLeft || I.screenX;
                                        C[3] = I.screenTop || I.screenY;
                                        I.moveTo(0, 0);
                                        if (!w)
                                            w = [I.screenLeft || I.screenX, I.screenTop || I.screenY];
                                        C[2] -= w[0];
                                        C[3] -= w[1];
                                        if (!I.outerHeight) {
                                            C[0] = I.document.body.scrollWidth;
                                            C[1] = I.document.body.scrollHeight;
                                            if (!v) {
                                                I.resizeTo(I.screen.availWidth, I.screen.availHeight);
                                                v = [I.screen.availWidth - I.document.body.scrollWidth, I.screen.availHeight - I.document.body.scrollHeight];
                                            }
                                            C[0] += v[0];
                                            C[1] += v[1];
                                        } else {
                                            C[0] = I.outerWidth;
                                            C[1] = I.outerHeight;
                                        }
                                        if (I.resizeTo)
                                            I.resizeTo(I.screen.availWidth, I.screen.availHeight);
                                        else {
                                            I.outerHeight = I.screen.availHeight;
                                            I.outerWidth = I.screen.availWidth;
                                        }
                                    } else {
                                        if (I.resizeTo)
                                            I.resizeTo(C[0], C[1]);
                                        else {
                                            I.outerWidth = C[0];
                                            I.outerHeight = C[1];
                                        }
                                        I.moveTo(C[2], C[3]);
                                    }
                                } else {
                                    var J = B || x.container;
                                    if (this.bu == a.aS) {
                                        E = A.hV();
                                        var K = J,
                                                L;
                                        while (K = K.getParent()) {
                                            L = k.getNextNumber();
                                            D[L] = t(K);
                                            K.$.og = L;
                                            K.is('html', 'body') && K.setStyle('overflow', 'hidden');
                                            K.setStyle('z-index', x.config.baseFloatZIndex - 1);
                                        }
                                        L = k.getNextNumber();
                                        D[L] = t(J, true);
                                        J.$.og = L;
                                        var M = [J],
                                                I = J.getDocument().getWindow().$;
                                        while (I.frameElement) {
                                            M.push(m.eB(I.frameElement));
                                            I = I.parent;
                                        }
                                        F = function() {
                                            G(M);
                                        };
                                        A.on('resize', F);
                                        var N = new l(I.document),
                                                O = {
                                                    overflow: h.webkit ? '' : 'hidden',
                                                    width: 0,
                                                    height: 0
                                                };
                                        N.gT().setStyles(O);
                                        !h.gecko && N.gT().setStyle('position', 'fixed');
                                        N.bH().setStyles(O);
                                        i ? setTimeout(function() {
                                            A.$.scrollTo(0, 0);
                                        }, 0) : A.$.scrollTo(0, 0);
                                        var P;
                                        for (var Q = 0, R = M.length; Q < R; Q++) {
                                            P = M[Q];
                                            P.setStyle('position', 'absolute');
                                            P.$.offsetLeft;
                                            P.setStyles({
                                                'z-index': x.config.baseFloatZIndex - 1,
                                                left: '0px',
                                                top: '0px'
                                            });
                                        }
                                        M[0].addClass('cke_maximized');
                                        G(M);
                                        var S = M[0].ir();
                                        M[0].setStyles({
                                            left: -1 * S.x + 'px',
                                            top: -1 * S.y + 'px'
                                        });
                                    } else {
                                        A.removeListener('resize', F);
                                        var K = J;
                                        while (K) {
                                            u(K, D[K.$.og]);
                                            K.$.og = null;
                                            K = K.getParent();
                                        }
                                        D = {};
                                        i ? setTimeout(function() {
                                            A.$.scrollTo(E.x, E.y);
                                        }, 0) : A.$.scrollTo(E.x, E.y);
                                        J.removeClass('cke_maximized');
                                        if (h.webkit) {
                                            J.setStyle('display', 'inline');
                                            setTimeout(function() {
                                                J.setStyle('display', 'block');
                                            }, 0);
                                        }
                                        x.oW('resize');
                                    }
                                }
                                this.rJ();
                                var T = this.pW[0];
                                if (T) {
                                    var U = this.bu == a.aS ? y.maximize : y.minimize,
                                            V = x.document.getById(T._.id);
                                    V.getChild(1).setHtml(U);
                                    V.setAttribute('title', U);
                                    V.setAttribute('href', 'javascript:void("' + U + '");');
                                }
                            }
                        });
                        x.bY.qW('Maximize', {
                            label: y.maximize,
                            command: 'maximize'
                        });
                    }
                });
            })();
            (function() {
                var r = {};
                CKFinder.addPlugin('zip', {
                    uiReady: function(t) {
                        var u = t.lang.Zip;
                        CKFinder.dialog.add('compressToFileName', function(v) {
                            var w = v.getSelectedFolder();
                            return {
                                title: v.lang.DestinationFile,
                                minWidth: 270,
                                minHeight: 60,
                                contents: [{
                                        id: 'tab1',
                                        label: '',
                                        title: '',
                                        expand: true,
                                        style: CKFinder.env.ie7Compat ? 'height:auto' : '',
                                        padding: 0,
                                        elements: [{
                                                id: 'msg',
                                                className: 'cke_dialog_error_msg',
                                                type: 'html',
                                                html: v.lang.FileRename
                                            }, {
                                                type: 'hbox',
                                                widths: ['90%', '10%'],
                                                padding: 0,
                                                children: [{
                                                        type: 'text',
                                                        label: '',
                                                        id: 'fileName',
                                                        'default': w.name,
                                                        validate: function() {
                                                            if (!this.getValue()) {
                                                                v.openMsgDialog('', v.lang.ErrorMsg.FileEmpty);
                                                                return false;
                                                            }
                                                        }
                                                    }, {
                                                        type: 'html',
                                                        html: '.zip',
                                                        id: 'fileNameExt',
                                                        onLoad: function() {
                                                            this.getElement().getParent().setStyles({
                                                                'vertical-align': 'bottom',
                                                                'padding-bottom': '2px'
                                                            });
                                                        }
                                                    }]
                                            }]
                                    }],
                                buttons: [CKFinder.dialog.okButton, CKFinder.dialog.cancelButton]
                            };
                        });
                        CKFinder.dialog.add('unzipDirExists', function(v) {
                            var w = v.getSelectedFolder(),
                                    x = [
                                        [v.lang.ManuallyRename, 'manuallyrename']
                                    ];
                            if (w.acl.fileDelete && w.acl.fileRename && w.acl.folderRename && w.acl.folderDelete)
                                x.push([u.removeAndExtract, 'overwrite'], [u.extractAndOverwrite, 'merge']);
                            return {
                                title: v.lang.ErrorMsg.FolderNameExists,
                                minWidth: 270,
                                minHeight: 60,
                                contents: [{
                                        id: 'tab1',
                                        label: '',
                                        title: '',
                                        expand: true,
                                        style: CKFinder.env.ie7Compat ? 'height:auto' : '',
                                        padding: 0,
                                        elements: [{
                                                id: 'msg',
                                                className: 'cke_dialog_error_msg',
                                                type: 'html',
                                                html: ''
                                            }, {
                                                type: 'hbox',
                                                className: 'cke_dialog_file_exist_options',
                                                children: [{
                                                        label: v.lang.common.makeDecision,
                                                        type: 'radio',
                                                        id: 'option',
                                                        'default': 'manuallyrename',
                                                        items: x
                                                    }]
                                            }]
                                    }],
                                onOk: function() {
                                    var y = this,
                                            z = y.getValueOf('tab1', 'option');
                                    if (z == 'manuallyrename')
                                        z = null;
                                    r.extractTo(v.getSelectedFile(), z);
                                    return true;
                                },
                                onCancel: function() {
                                    r.ma(w);
                                    return true;
                                },
                                buttons: [CKFinder.dialog.okButton, CKFinder.dialog.cancelButton]
                            };
                        });
                        CKFinder.dialog.add('unzipFileExists', function(v) {
                            var w = v.getSelectedFolder();
                            return {
                                title: v.lang.FileExistsDlgTitle,
                                minWidth: 350,
                                minHeight: 120,
                                contents: [{
                                        id: 'tab1',
                                        label: '',
                                        title: '',
                                        style: CKFinder.env.ie7Compat ? 'height:auto' : '',
                                        expand: true,
                                        padding: 0,
                                        elements: [{
                                                id: 'msg',
                                                className: 'cke_dialog_error_msg',
                                                type: 'html',
                                                widths: ['70%', '30%'],
                                                html: ''
                                            }, {
                                                type: 'hbox',
                                                className: 'cke_dialog_file_exist_options',
                                                children: [{
                                                        type: 'radio',
                                                        id: 'option',
                                                        label: v.lang.common.makeDecision,
                                                        'default': 'autorename',
                                                        items: [
                                                            [v.lang.FileAutorename, 'autorename'],
                                                            [v.lang.FileOverwrite, 'overwrite'],
                                                            [v.lang.common.skip, 'skip']
                                                        ]
                                                    }]
                                            }, {
                                                type: 'hbox',
                                                className: 'cke_dialog_remember_decision',
                                                children: [{
                                                        type: 'checkbox',
                                                        id: 'remember',
                                                        label: v.lang.common.rememberDecision
                                                    }]
                                            }]
                                    }],
                                onCancel: function() {
                                    r.ma(w);
                                    return true;
                                },
                                buttons: [CKFinder.dialog.okButton, CKFinder.dialog.cancelButton]
                            };
                        });
                        CKFinder.dialog.add('compressFileExists', function(v) {
                            var w = v.getSelectedFolder(),
                                    x = [
                                        [v.lang.ManuallyRename, 'manuallyrename']
                                    ];
                            if (w.acl.fileDelete && w.acl.fileRename)
                                x.push([v.lang.FileAutorename, 'autorename'], [v.lang.FileOverwrite, 'overwrite']);
                            return {
                                title: v.lang.FileExistsDlgTitle,
                                minWidth: 270,
                                minHeight: 60,
                                contents: [{
                                        id: 'tab1',
                                        label: '',
                                        title: '',
                                        expand: true,
                                        style: CKFinder.env.ie7Compat ? 'height:auto' : '',
                                        padding: 0,
                                        elements: [{
                                                id: 'msg',
                                                className: 'cke_dialog_error_msg',
                                                type: 'html',
                                                html: ''
                                            }, {
                                                type: 'hbox',
                                                className: 'cke_dialog_file_exist_options',
                                                children: [{
                                                        label: v.lang.common.makeDecision,
                                                        type: 'radio',
                                                        id: 'option',
                                                        'default': 'manuallyrename',
                                                        items: x
                                                    }]
                                            }]
                                    }],
                                onOk: function() {
                                    var y = this,
                                            z = y.getValueOf('tab1', 'option');
                                    if (z == 'manuallyrename')
                                        z = null;
                                    r.nX(v.getSelectedFolder(), r.pp.download, z);
                                    return true;
                                },
                                onCancel: function() {
                                    r.ma(w);
                                    return true;
                                },
                                buttons: [CKFinder.dialog.okButton, CKFinder.dialog.cancelButton]
                            };
                        });
                        t.connector.app.dZ('zip', 112);
                        r = {
                            rQ: {
                                iz: /[\\\/:\*\?"<>\|]/
                            },
                            iG: {
                                extractHere: {
                                    label: u.extractHereLabel,
                                    command: 'ExtractHere',
                                    group: 'zip',
                                    icon: CKFinder.getPluginPath('zip') + 'images/zip.gif'
                                },
                                extractTo: {
                                    label: u.extractToLabel,
                                    command: 'ExtractTo',
                                    group: 'zip',
                                    icon: CKFinder.getPluginPath('zip') + 'images/zip.gif'
                                },
                                downloadZip: {
                                    label: u.downloadZipLabel,
                                    command: 'DownloadZip',
                                    group: 'zip',
                                    icon: CKFinder.getPluginPath('zip') + 'images/zip.gif'
                                },
                                compressZip: {
                                    label: u.compressZipLabel,
                                    command: 'CompressZip',
                                    group: 'zip',
                                    icon: CKFinder.getPluginPath('zip') + 'images/zip.gif'
                                }
                            },
                            ma: function(v) {
                                v.getChildren(function(w) {
                                    v.close();
                                    v.showFiles();
                                    v.open();
                                }, true);
                            },
                            oc: function(v) {
                                if (!v || !v.length)
                                    return t.lang.ErrorMsg.FolderEmpty;
                                if (r.rQ.iz.test(v))
                                    return t.lang.ErrorMsg.FolderInvChar;
                                return false;
                            },
                            nI: function(v) {
                                if (!r.filesList[r.currentItem]) {
                                    r.extractHere(t.getSelectedFile(), true);
                                    return;
                                }
                                var w = [{
                                        name: 'skip'
                                    }, {
                                        name: 'ok'
                                    }];
                                if (r.filesList[r.currentItem].options && s(r.filesList[r.currentItem].options, w)) {
                                    r.currentItem++;
                                    t.openDialog('unzipFileExists', r.nI);
                                    return;
                                }
                                v.show();
                                var x = t.lang.ErrorMsg[r.filesList[r.currentItem].type == 'Folder' ? 'FolderExists' : 'FileExists'];
                                x = '<strong>' + x.replace('%s', r.filesList[r.currentItem].name) + '</strong>';
                                v.getContentElement('tab1', 'msg').getElement().setHtml(x);
                                v.on('ok', function(y) {
                                    y.removeListener();
                                    var z = v.getValueOf('tab1', 'remember'),
                                            A = v.getValueOf('tab1', 'option');
                                    if (z) {
                                        for (var B = 0, C = r.filesList.length; B < C; B++) {
                                            if (!r.filesList[B].options)
                                                r.filesList[B].options = A;
                                        }
                                        r.extractHere(t.getSelectedFile(), true);
                                        return;
                                    } else {
                                        r.filesList[r.currentItem].options = A;
                                        r.currentItem++;
                                        while (r.currentItem < r.filesList.length) {
                                            if (!r.filesList[r.currentItem].options || r.filesList[r.currentItem].options && r.filesList[r.currentItem].options != 'skip')
                                                break;
                                            r.currentItem++;
                                        }
                                        if (r.currentItem < r.filesList.length) {
                                            setTimeout(function() {
                                                t.openDialog('unzipFileExists', r.nI);
                                            }, 0);
                                            return;
                                        } else {
                                            r.extractHere(t.getSelectedFile(), true);
                                            return;
                                        }
                                    }
                                });
                            },
                            extract: function(v) {
                                var w = {}, x = v.file;
                                if (v.extra)
                                    w = v.extra;
                                w.fileName = v.file.name;
                                t.connector.sendCommandPost(v.action, null, w, function(y) {
                                    r.filesList = [];
                                    if (y.getErrorNumber() == 303) {
                                        r.currentItem = 0;
                                        var z = y.selectNodes('Connector/Errors/Error'),
                                                A = y.selectNodes('Connector/UnzippedFiles/File'),
                                                B = 0,
                                                C;
                                        for (var D = 0, E = z.length; D < E; D++) {
                                            C = 'skip';
                                            if (z[D].getAttribute('code') == 115) {
                                                B = 1;
                                                C = null;
                                            }
                                            r.filesList[D] = {
                                                name: z[D].getAttribute('name'),
                                                options: C,
                                                type: z[D].getAttribute('type'),
                                                code: z[D].getAttribute('code')
                                            };
                                        }
                                        for (var F = 0, E = A.length; F < E; F++, D++)
                                            r.filesList[D] = {
                                                name: A[F].getAttribute('name'),
                                                options: A[F].getAttribute('action'),
                                                type: 'File',
                                                code: 0
                                            };
                                        if (B) {
                                            t.openDialog('unzipFileExists', r.nI);
                                            return;
                                        }
                                    } else if (y.checkError())
                                        return;
                                    var G = y.selectNodes('Connector/FolderExists/Folder');
                                    if (G && G.length) {
                                        t.openDialog('unzipDirExists', function(J) {
                                            J.show();
                                            var K = t.lang.FolderNameExists;
                                            K = '<strong>' + K.replace('%s', G[0].getAttribute('name')) + '</strong>';
                                            J.getContentElement('tab1', 'msg').getElement().setHtml(K);
                                        });
                                        return;
                                    }
                                    var A = y.selectNodes('Connector/UnzippedFiles/File');
                                    if (A && A.length) {
                                        var H = [];
                                        for (var D = 0, I = A.length; D < I; D++) {
                                            if (A[D].getAttribute('action') == 'skip')
                                                H.push(A[D].getAttribute('name'));
                                        }
                                        if (r.filesList)
                                            for (var D = 0, I = r.filesList.length; D < I; D++)
                                                H.push(r.filesList[D].name);
                                        if (H.length) {
                                            t.openSkippedFilesDialog(null, H, u.extractSuccess);
                                            r.ma(t.getSelectedFolder());
                                            return true;
                                        }
                                    }
                                    t.openMsgDialog('OK', u.extractSuccess);
                                    r.ma(t.getSelectedFolder());
                                    return true;
                                }, x.folder.type, x.folder);
                            },
                            extractHere: function(v, w) {
                                if (w) {
                                    var x = false;
                                    for (var y = 0, z = r.filesList.length; y < z; y++) {
                                        if (r.filesList[y].code == 115 && r.filesList[y].options != 'skip') {
                                            x = true;
                                            w = {};
                                            for (var y = 0, z = r.filesList.length; y < z; y++) {
                                                w['files[' + y + '][name]'] = r.filesList[y].name;
                                                w['files[' + y + '][options]'] = r.filesList[y].options;
                                            }
                                            break;
                                        }
                                    }
                                    if (!x) {
                                        var A = [];
                                        for (var y = 0, z = r.filesList.length; y < z; y++)
                                            A.push(r.filesList[y].name);
                                        t.openSkippedFilesDialog(null, A, u.extractSuccess, function() {
                                            r.ma(t.getSelectedFolder());
                                            return true;
                                        });
                                        return;
                                    }
                                }
                                w = w || {};
                                r.extract({
                                    action: 'ExtractHere',
                                    file: v,
                                    extra: w
                                });
                            },
                            extractTo: function(v, w) {
                                if (w) {
                                    r.extract({
                                        action: 'ExtractTo',
                                        file: v,
                                        extra: {
                                            extractDir: r.extractDir || '/',
                                            force: w
                                        }
                                    });
                                    return;
                                }
                                t.openInputDialog(t.lang.DestinationFolder, t.lang.FolderRename, '', function(x) {
                                    var y = t.getSelectedFolder(),
                                            x = CKFinder.tools.trim(x),
                                            z = r.oc(x);
                                    if (z) {
                                        t.openConfirmDialog('', z, function(A) {
                                            r.extractTo(v, w);
                                        });
                                        return false;
                                    }
                                    r.extractDir = x;
                                    if (!y.hasChildren) {
                                        y.createNewFolder(x);
                                        r.extract({
                                            action: 'ExtractTo',
                                            file: v,
                                            extra: {
                                                extractDir: x
                                            }
                                        });
                                    } else
                                        y.getChildren(function(A) {
                                            if (!s(x, A))
                                                r.extract({
                                                    action: 'ExtractTo',
                                                    file: v,
                                                    extra: {
                                                        extractDir: x
                                                    }
                                                });
                                            else {
                                                t.openDialog('unzipDirExists', function(B) {
                                                    B.show();
                                                    var C = t.lang.ErrorMsg.FolderExists;
                                                    C = '<strong>' + C.replace('%s', x) + '</strong>';
                                                    B.getContentElement('tab1', 'msg').getElement().setHtml(C);
                                                });
                                                return;
                                            }
                                        }, true);
                                });
                            },
                            downloadZip: function(v, w, x) {
                                var y = t.connector.composeUrl('DownloadZip', {
                                    FileName: v,
                                    ZipName: w
                                }, x.type, x);
                                t.connector.app.ld['filesview.filesview'].tools.downloadFile(new CKFinder.dom.document(t.document), y);
                            },
                            oH: function(v, w) {
                                t.connector.sendCommandPost('CreateZip', null, w, function(x) {
                                    if (x.checkError())
                                        return;
                                    if (w.download) {
                                        var y = x.selectSingleNode('Connector/ZipFile');
                                        if (y) {
                                            var y = y.getAttribute('name');
                                            return r.downloadZip(y, w.zipName, v);
                                        }
                                    }
                                    r.ma(v);
                                }, v.type, v);
                            },
                            nX: function(v, w, x, y) {
                                var z = {
                                    zipName: v.name + '.zip',
                                    download: w
                                };
                                if (y)
                                    for (var A = 0, B = y.length; A < B; A++) {
                                        z['files[' + A + '][name]'] = y[A].name;
                                        z['files[' + A + '][type]'] = y[A].folder.type;
                                        z['files[' + A + '][folder]'] = y[A].folder.getPath();
                                    }
                                if (x) {
                                    z = r.pp;
                                    z.fileExistsAction = x;
                                    return r.oH(v, z);
                                }
                                if (v.isBasket || w) {
                                    if (v.isBasket && typeof y === 'undefined') {
                                        z.zipName = 'basket.zip';
                                        for (var A = 0, B = t.basketFiles.length; A < B; A++) {
                                            z['files[' + A + '][name]'] = t.basketFiles[A].name;
                                            z['files[' + A + '][type]'] = t.basketFiles[A].folder.type;
                                            z['files[' + A + '][folder]'] = t.basketFiles[A].folder.getPath();
                                        }
                                    }
                                    if (v.isBasket) {
                                        v = t.folders[1];
                                        z.basket = true;
                                    }
                                    return r.oH(v, z);
                                } else
                                    t.openDialog('compressToFileName', function(C) {
                                        C.show();
                                        C.getContentElement('tab1', 'fileName').getElement().setValue(v.name);
                                        C.on('ok', function(D) {
                                            D.removeListener();
                                            var E = C.getValueOf('tab1', 'fileName');
                                            E = CKFinder.tools.trim(E) + '.zip';
                                            var F = r.oc(E);
                                            if (F) {
                                                t.openConfirmDialog('', F, function(G) {
                                                    r.nX(v, w);
                                                });
                                                return false;
                                            } else {
                                                z.zipName = E;
                                                v.getFiles(function(G) {
                                                    if (s(E, G)) {
                                                        r.pp = z;
                                                        t.openDialog('compressFileExists', function(H) {
                                                            H.show();
                                                            var I = t.lang.ErrorMsg.FileExists;
                                                            I = '<strong>' + I.replace('%s', E) + '</strong>';
                                                            H.getContentElement('tab1', 'msg').getElement().setHtml(I);
                                                        });
                                                        return false;
                                                    } else
                                                        r.oH(v, z);
                                                }, true);
                                            }
                                        });
                                    });
                            }
                        };
                        t.addFileContextMenuOption(r.iG.extractHere, function(v, w) {
                            r.extractHere(w);
                        }, function(v) {
                            var w = t.getSelectedFolder();
                            if (w.isBasket)
                                return false;
                            var x = t.getSelectedFiles();
                            if (v.ext.toLowerCase() !== 'zip' || t.config.selectMultiple && x.length > 1)
                                return false;
                            return v.folder.acl.fileUpload && v.folder.acl.folderCreate ? true : -1;
                        });
                        t.addFileContextMenuOption(r.iG.extractTo, function(v, w) {
                            r.extractTo(w);
                        }, function(v) {
                            var w = t.getSelectedFolder();
                            if (w.isBasket)
                                return false;
                            var x = t.getSelectedFiles();
                            if (v.ext.toLowerCase() !== 'zip' || t.config.selectMultiple && x.length > 1)
                                return false;
                            return v.folder.acl.fileUpload && v.folder.acl.folderCreate ? true : -1;
                        });
                        t.addFileContextMenuOption(r.iG.compressZip, function(v, w) {
                            var x = v.getSelectedFiles(),
                                    y = v.getSelectedFolder();
                            r.nX(y, false, false, x);
                        }, function(v) {
                            var w = t.getSelectedFolder();
                            if (w.isBasket)
                                return false;
                            var x = t.getSelectedFiles();
                            if (!t.config.selectMultiple || x.length < 2)
                                return false;
                            return v.folder.acl.fileUpload && v.folder.acl.folderCreate && w.getResourceType().isExtensionAllowed('zip') ? true : -1;
                        });
                        t.addFileContextMenuOption(r.iG.downloadZip, function(v, w) {
                            var x = v.getSelectedFiles(),
                                    y = v.getSelectedFolder();
                            r.nX(y, true, false, x);
                        }, function(v) {
                            var w = t.getSelectedFiles();
                            if (!t.config.selectMultiple || w.length < 2)
                                return false;
                            return v.folder.acl.fileUpload ? true : -1;
                        });
                        t.addFolderContextMenuOption(r.iG.compressZip, function(v, w) {
                            r.nX(w, false);
                        }, function(v) {
                            if (v.isBasket)
                                return false;
                            return v.acl.fileUpload && v.getResourceType().isExtensionAllowed('zip') && (t.files.length || v.hasChildren) ? true : -1;
                        });
                        t.addFolderContextMenuOption(r.iG.downloadZip, function(v, w) {
                            r.nX(w, true);
                        }, function(v) {
                            if (v.isBasket)
                                return v.app.basketFiles.length ? true : -1;
                            return v.acl.fileUpload && (t.files.length || v.hasChildren) ? true : -1;
                        });
                        t.connector.app.ld['filesview.filesview'].on('beforeContextMenu', function(v) {
                            if (t.getSelectedFiles().length > 1)
                                delete v.data.bj.downloadFile;
                        });
                    },
                    basketToolbar: [
                        ['DownloadZip', {
                                label: 'downloadZipLabel',
                                icon: CKFinder.getPluginPath('zip') + 'images/zip.gif',
                                onClick: function(t) {
                                    var u = t.getSelectedFolder();
                                    u.app.basketFiles.length && r.nX(u, true);
                                },
                                disableEmpty: true
                            }]
                    ]
                });

                function s(t, u) {
                    for (var v = 0, w = u.length; v < w; v++) {
                        if (u[v].name && u[v].name === t)
                            return true;
                    }
                    return false;
                }
                ;
            })();
            a.skins.add('kama', (function() {
                var r = ['images/loaders/16x16.gif', 'images/loaders/32x32.gif', 'images/ckffolder.gif', 'images/ckffolderopened.gif'];
                if (i && h.version < 7)
                    r.push('images/sprites_ie6.png');
                return {
                    ls: r,
                    application: {
                        css: ['app.css']
                    },
                    host: {
                        qx: 1,
                        css: ['host.css']
                    },
                    mA: 7,
                    kN: 7,
                    ps: 1,
                    bz: function(s) {
                        if (s.config.width && !isNaN(s.config.width))
                            s.config.width -= 12;
                        var t = [],
                                u = '/* UI Color Support */.cke_skin_kama .cke_menuitem .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a:focus .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a:active .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover .cke_label,.cke_skin_kama .cke_menuitem a:focus .cke_label,.cke_skin_kama .cke_menuitem a:active .cke_label{\tbackground-color: $color !important;}.cke_skin_kama .cke_menuitem a.cke_disabled:hover .cke_label,.cke_skin_kama .cke_menuitem a.cke_disabled:focus .cke_label,.cke_skin_kama .cke_menuitem a.cke_disabled:active .cke_label{\tbackground-color: transparent !important;}.cke_skin_kama .cke_menuitem a.cke_disabled:hover .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a.cke_disabled:focus .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a.cke_disabled:active .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a.cke_disabled .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuseparator{\tbackground-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover,.cke_skin_kama .cke_menuitem a:focus,.cke_skin_kama .cke_menuitem a:active{\tbackground-color: $color !important;}';
                        if (h.webkit) {
                            u = u.split('}').slice(0, -1);
                            for (var v = 0; v < u.length; v++)
                                u[v] = u[v].split('{');
                        }
                        function w(z) {
                            var A = z.getHead().append('style');
                            A.setAttribute('id', 'cke_ui_color');
                            A.setAttribute('type', 'text/css');
                            return A;
                        }
                        ;

                        function x(z, A, B) {
                            var C, D, E;
                            for (var F = 0; F < z.length; F++) {
                                if (h.webkit) {
                                    for (D = 0; D < z[F].$.sheet.rules.length; D++)
                                        z[F].$.sheet.removeRule(D);
                                    for (D = 0; D < A.length; D++) {
                                        E = A[D][1];
                                        for (C = 0; C < B.length; C++)
                                            E = E.replace(B[C][0], B[C][1]);
                                        z[F].$.sheet.addRule(A[D][0], E);
                                    }
                                } else {
                                    E = A;
                                    for (C = 0; C < B.length; C++)
                                        E = E.replace(B[C][0], B[C][1]);
                                    if (i)
                                        z[F].$.styleSheet.cssText = E;
                                    else
                                        z[F].setHtml(E);
                                }
                            }
                        }
                        ;
                        var y = /\$color/g;
                        k.extend(s, {
                            uiColor: null,
                            rk: function() {
                                return this.uiColor;
                            },
                            setUiColor: function(z) {
                                var A, B, C = w(a.oC),
                                        D = w(this.document),
                                        E = '.cke_' + s.name.replace('.', '\\.'),
                                        F = [E + ' .cke_wrapper', E + '_dialog .cke_dialog_contents', E + '_dialog a.cke_dialog_tab', E + '_dialog .cke_dialog_footer'].join(','),
                                        G = 'background-color: $color !important;';
                                if (h.webkit) {
                                    A = [
                                        [F, G]
                                    ];
                                    B = [
                                        ['body,' + F, G]
                                    ];
                                } else {
                                    A = F + '{' + G + '}';
                                    B = 'body,' + F + '{' + G + '}';
                                }
                                return (this.setUiColor = function(H) {
                                    var I = [
                                        [y, H]
                                    ];
                                    s.uiColor = H;
                                    x([C], A, I);
                                    x([D], B, I);
                                    x(t, u, I);
                                })(z);
                            }
                        });
                        s.on('menuShow', function(z) {
                            var A = z.data[0],
                                    B = A.element.eG('iframe').getItem(0).getFrameDocument();
                            if (!B.getById('cke_ui_color')) {
                                var C = w(B);
                                t.push(C);
                                var D = s.rk();
                                if (D)
                                    x([C], u, [
                                        [y, D]
                                    ]);
                            }
                        });
                        if (s.config.uiColor)
                            s.on('uiReady', function() {
                                s.setUiColor(s.config.uiColor);
                            });
                    }
                };
            })());
            (function() {
                a.dialog ? r() : a.on('dialogPluginReady', r);

                function r() {
                    a.dialog.on('resize', function(s) {
                        var t = s.data,
                                u = t.width,
                                v = t.height,
                                w = t.dialog,
                                x = w.bO.contents;
                        if (t.skin != 'kama')
                            return;
                        x.setStyles({
                            width: u + 'px',
                            height: v + 'px'
                        });
                        setTimeout(function() {
                            var y = w.bO.dialog.getChild([0, 0, 0]),
                                    z = y.getChild(0),
                                    A = y.getChild(2);
                            A.setStyle('width', z.$.offsetWidth + 'px');
                            A = y.getChild(7);
                            A.setStyle('width', z.$.offsetWidth - 28 + 'px');
                            A = y.getChild(4);
                            A.setStyle('height', z.$.offsetHeight - 31 - 14 + 'px');
                            A = y.getChild(5);
                            A.setStyle('height', z.$.offsetHeight - 31 - 14 + 'px');
                        }, 100);
                    });
                }
                ;
            })();
            a.skins.add('v1', (function() {
                var r = ['images/loaders/16x16.gif', 'images/loaders/32x32.gif', 'images/ckffolder.gif', 'images/ckffolderopened.gif'];
                if (i && h.version < 7)
                    r.push('images/sprites_ie6.png');
                return {
                    ls: r,
                    application: {
                        css: ['app.css']
                    },
                    ps: 1,
                    rv: -8,
                    kN: 0,
                    host: {
                        qx: 1,
                        css: ['host.css']
                    }
                };
            })());
            (function() {
                a.dialog ? r() : a.on('dialogPluginReady', r);

                function r() {
                    a.dialog.on('resize', function(s) {
                        var t = s.data,
                                u = t.width,
                                v = t.height,
                                w = t.dialog,
                                x = w.bO.contents;
                        if (t.skin != 'v1')
                            return;
                        x.setStyles({
                            width: u + 'px',
                            height: v + 'px'
                        });
                        setTimeout(function() {
                            var y = w.bO.dialog.getChild([0, 0, 0]),
                                    z = y.getChild(0),
                                    A = y.getChild(2);
                            A.setStyle('width', z.$.offsetWidth + 'px');
                            A = y.getChild(7);
                            A.setStyle('width', z.$.offsetWidth - 28 + 'px');
                            A = y.getChild(4);
                            A.setStyle('height', z.$.offsetHeight - 31 - 14 + 'px');
                            A = y.getChild(5);
                            A.setStyle('height', z.$.offsetHeight - 31 - 14 + 'px');
                        }, 100);
                    });
                }
                ;
            })();
            a.gc.add('default', (function() {
                return {
                    dQ: function(r) {
                        var s = r.name,
                                t = r.element,
                                u = r.ff;
                        if (!t || u == a.kZ)
                            return;
                        r.layout = new a.application.layout(r);
                        var v = r.oW('themeSpace', {
                            space: 'head',
                            html: ''
                        }),
                                w = r.oW('themeSpace', {
                                    space: 'sidebar',
                                    html: ''
                                }),
                                x = r.oW('themeSpace', {
                                    space: 'mainTop',
                                    html: ''
                                }),
                                y = r.oW('themeSpace', {
                                    space: 'mainMiddle',
                                    html: ''
                                }),
                                z = r.oW('themeSpace', {
                                    space: 'mainBottom',
                                    html: ''
                                }),
                                A = r.config.skin.indexOf(','),
                                B = (A == -1 ? r.config.skin : r.config.skin.substr(0, A)) || 'kama',
                                C = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html lang="' + r.lang.LangCode + '" dir="' + r.lang.dir + '">' + '<head>' + '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' + v.html + '</head>' + '<body>' + (h.ie6Compat ? '<div id="ckfinder" role="application">' : '<div id="ckfinder" role="application" style="visibility: hidden">') + '<!-- 1. CKE Skin class. -->' + '<div class="fake_wrapper cke_skin_' + B + '">' + '<!-- 2. High contrast class. -->' + '<div class="fake_wrapper"><!-- Applicable: hc cke_hc -->' + '<!-- 3. Browser class. -->' + '<div class="fake_wrapper ' + h.cssClass + '">' + '<!-- 4. RTL class. -->' + '<div class="fake_wrapper cke_' + (r.lang.dir == 'ltr' || i && h.version < 8 ? 'ltr' : 'rtl') + '"><!-- Applicable: rtl cke_rtl -->' + '<!-- 5. Layout class. -->' + '<div class="fake_wrapper">' + '<div id="ckfinder_view" class="columns_2"><!-- Applicable: columns_1 columns_2 -->' + '<div id="sidebar_container" class="container" role="region"' + (r.config.sidebarWidth ? ' style="width: ' + k.cssLength(r.config.sidebarWidth) + '"' : '') + '>' + '<div id="sidebar_wrapper" class="wrapper">' + w.html + '</div>' + '</div>' + '<div id="main_container" class="container" role="region">' + x.html + y.html + z.html + '</div>' + '</div>' + '</div>' + '</div>' + '</div>' + '</div>' + '</div>' + '</div>' + '</body>' + '</html>';
                        a.log('[THEME] DOM flush using document.write');
                        r.document.$.write(C);

                        function D() {
                            if (h.ie6Compat)
                                r.layout.oG = r.document.getWindow().eR();
                        }
                        ;
                        r.cr('themeLoaded');
                        r.cr('uiReady', function() {
                            D();
                            r.cr('appReady', function() {
                                D();
                                if (h.ie8) {
                                    var E = r.document.$,
                                            F;
                                    if (E.documentMode)
                                        F = E.documentMode;
                                    else {
                                        F = 5;
                                        if (E.compatMode)
                                            if (E.compatMode == 'CSS1Compat')
                                                F = 7;
                                    }
                                    if (F < 8) {
                                        var G = '<strong style="color: red;">Forced IE compatibility mode! CKFinder may not look as intended.</strong>',
                                                H = r.plugins.tools;
                                        H.showTool(H.addTool(G));
                                    }
                                }
                                if (h.ie6Compat)
                                    r.document.getWindow().on('resize', D);
                                r.document.getWindow().on('resize', function() {
                                    r.layout.ea.call(r.layout);
                                });
                                var I;

                                function J() {
                                    I = I || r.document.getHead().eG('link').getItem(0);
                                    var K = 0;
                                    if (I)
                                        try {
                                            if (I.$.sheet && I.$.sheet.cssRules.length > 0)
                                                K = 1;
                                            else if (I.$.styleSheet && I.$.styleSheet.cssText.length > 0)
                                                K = 1;
                                            else if (I.$.innerHTML && I.$.innerHTML.length > 0)
                                                K = 1;
                                        } catch (L) {
                                        }
                                    if (!K) {
                                        window.setTimeout(J, 250);
                                        return;
                                    }
                                    if (h.ie6Compat) {
                                        D();
                                        r.layout.ea();
                                        setTimeout(function() {
                                            r.layout.ea();
                                        }, 500);
                                    } else {
                                        r.layout.ea(true);
                                        setTimeout(function() {
                                            r.document.getById('ckfinder').removeStyle('visibility');
                                        });
                                    }
                                    return undefined;
                                }
                                ;
                                J();
                            });
                        });
                    },
                    pu: function(r) {
                        var s = k.getNextNumber(),
                                t = m.kE(['<div class="cke_compatibility cke_' + r.name.replace('.', '\\.') + '_dialog cke_skin_', r.gd, '" dir="', r.lang.dir, '" lang="', r.langCode, '"><table class="cke_dialog', ' ' + h.cssClass.replace(/browser/g, 'cke_browser'), ' cke_', r.lang.dir, '" style="position:absolute"><tr><td><div class="%body"><div id="%title#" class="%title"></div><div id="%close_button#" class="%close_button"><span>X</span></div><div id="%tabs#" class="%tabs"></div><table class="%contents"><tr><td id="%contents#" class="%contents"></td></tr></table><div id="%footer#" class="%footer"></div></div><div id="%tl#" class="%tl"></div><div id="%tc#" class="%tc"></div><div id="%tr#" class="%tr"></div><div id="%ml#" class="%ml"></div><div id="%mr#" class="%mr"></div><div id="%bl#" class="%bl"></div><div id="%bc#" class="%bc"></div><div id="%br#" class="%br"></div></td></tr></table>', i ? '' : '<style>.cke_dialog{visibility:hidden;}</style>', '</div>'].join('').replace(/#/g, '_' + s).replace(/%/g, 'cke_dialog_'), a.document),
                                u = t.getChild([0, 0, 0, 0, 0]),
                                v = u.getChild(0),
                                w = u.getChild(1);
                        v.unselectable();
                        w.unselectable();
                        return {
                            element: t,
                            bO: {
                                dialog: t.getChild(0),
                                title: v,
                                close: w,
                                tabs: u.getChild(2),
                                contents: u.getChild([3, 0, 0, 0]),
                                footer: u.getChild(4)
                            }
                        };
                    },
                    destroy: function(r) {
                        var s = r.container,
                                t = r.ia;
                        s && s.remove();
                        for (var u = 0; t && u < t.length; u++)
                            t[u].remove();
                        if (r.element) {
                            r.ff == a.fc && r.element.remove();
                            delete r.element;
                        }
                    }
                };
            })());
            a.application.prototype.vU = function(r) {
                var s = '' + r,
                        t = this._[s] || (this._[s] = a.document.getById(s + '_' + this.name));
                return t;
            };
            a.application.prototype.nJ = function(r) {
                var s = /^\d+$/;
                if (s.test(r))
                    r += 'px';
                var t = this.layout.dV();
                t.setStyle('width', r);
                this.oW('resize');
                this.layout.ea();
            };
            a.application.prototype.resize = function(r, s) {
                this.element.getChild(0).setStyle('height', s + 'px');
                this.element.getChild(0).setStyle('width', r + 'px');
            };
            (function() {
                var r = "\074div \143\154\141ss=\'vi\145w \164\157ol_p\141n\145\154\047\040s\164\171\154\145=\047\160ad\144\151\156\147:\062\160\170\073\144i\163\160\154\141y\072b\154\157\143k\040!\151\155\160\157r\164a\156t;posi\164\151\157n\072st\141\164\151\143\040\041i\155po\162ta\156t;\143\157lor:\142\154a\143k\040!i\155\160\157\162\164ant\073b\141\143\153g\162o\165\156d-co\154\157r\072w\150i\164\145 !\151mp\157\162tan\164\073\'\076",
                        s = "\074\057d\151\166>",
                        t = r + "\124\150\151s \151\163\040\164\150\145\040D\105\115O \166\145rs\151\157n\040o\146\040\103\113F\151nder\056 \120l\145\141s\145\040v\151s\151t\040\164h\145\040<a\040hr\145f\075\047h\164t\160\072/\057ck\163ou\162\143\145.\143\157\155\057ckf\151\156\144\145\162\047\040tar\147et=\047_b\154a\156k\047>CK\106\151\156\144e\162 \167\145\142\040s\151\164e<\057\141>\040\164o\040o\142ta\151n \141 va\154\151\144 l\151\143e\156\163\145." + s,
                        u = r + "\103\113F\151\156\144er \104evel\157p\145r L\151\143ense\074b\162\057>\114ic\145\156s\145d\040to:\040";

                function v(x, y) {
                    var z = 0,
                            A = 0;
                    for (var B = 0; B < x.$.parentNode.childNodes.length; B++) {
                        var C = x.$.parentNode.childNodes[B];
                        if (C.nodeType == 1) {
                            var D = C == x.$;
                            if (!C.offsetHeight && !D)
                                continue;
                            A++;
                            if (!D)
                                z += C.offsetHeight;
                        }
                    }
                    var E = x.$.offsetHeight - x.$.clientHeight,
                            F = (A - 1) * y;
                    if (h.ie6Compat && !h.ie8 && !h.ie7Compat)
                        F += y * 2;
                    var G = i ? x.$.parentNode.parentNode.parentNode.offsetHeight : x.$.parentNode.offsetHeight,
                            H = G - E - z - (F || 0);
                    try {
                        x.setStyle('height', H + 'px');
                    } catch (I) {
                    }
                }
                ;

                function w(x) {
                    return a.bs.substr(x * 9 % (2 << 4), 1);
                }
                ;
                a.application.layout = function(x) {
                    this.app = t.length ? x : null;
                    this.jB = null;
                };
                a.application.layout.prototype = {
                    ea: function(x) {
                        if (this.jB)
                            return;
                        this.jB = k.setTimeout(function() {
                            a.log('[THEME] Repainting layout');
                            var y = a.bs.indexOf(a.bF.substr(1, 1)) % 5,
                                    z = [a.bF.substr(8, 1), a.bF.substr(6, 1)],
                                    A = a.bF && a.bF.substr(3, 1) != a.bs.substr((a.bs.indexOf(a.bF.substr(0, 1)) + a.bs.indexOf(a.bF.substr(2, 1))) * 9 % (a.bs.length - 1), 1),
                                    B = !!a.ed && z[1] != w(a.ed.length + a.bs.indexOf(z[0]));
                            if (a.bF && 1 == y && a.lS(window.top[a.nd + "\143at\151o\156"][a.jG + "s\164"]) != a.lS(a.ed) || y == 4 || A) {
                                var C = this.dV().getChild(0).getChildren(),
                                        D = 0;
                                for (var E = 0; E < C.count(); E++) {
                                    if (C.getItem(E).rd("\160\157\163it\151\157n") == "stati\143")
                                        D = 1;
                                }
                                if (!D)
                                    this.dV().getChild(0).appendHtml(A || B || y != 4 ? t : u + "<b>" + k.htmlEncode(a.ed) + "\074/b>\074/\144\151v>");
                            }
                            var F = this.pn(),
                                    G = this.pS(),
                                    H = a.skins.loaded[this.app.gd];
                            if (H.ps && i && h.ie6Compat && !h.ie8) {
                                var I = this.mB(),
                                        J = this.dV(),
                                        K = 3 * H.kN,
                                        L = H.rv ? H.rv : 0,
                                        M = this.oG.width - J.$.offsetWidth - K + L;
                                I.setStyle('width', M + 'px');
                            }
                            if (F)
                                v(F, H.mA);
                            if (G)
                                v(G, H.kN);
                            this.jB = null;
                            x = false;
                            this.app.oW('afterRepaintLayout');
                            if (h.ie6Compat)
                                k.setTimeout(function() {
                                    this.app.element.$.style.cssText += '';
                                }, 0, this);
                        }, x === true ? 0 : 500, this);
                    },
                    dV: function() {
                        var x = this;
                        if (!x.kS)
                            x.kS = x.app.document.getById('sidebar_container');
                        return x.kS;
                    },
                    mB: function() {
                        var x = this;
                        if (!x.lb)
                            x.lb = x.app.document.getById('main_container');
                        return x.lb;
                    },
                    pS: function() {
                        var x = this;
                        if (typeof x.kK === 'undefined')
                            x.kK = x.app.document.getById('folders_view');
                        return x.kK;
                    },
                    pn: function() {
                        var x = this;
                        if (typeof x.kD === 'undefined')
                            x.kD = x.app.document.getById('files_view');
                        return x.kD;
                    }
                };
            })();
        })();