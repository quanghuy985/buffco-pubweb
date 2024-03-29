/*!
* jQuery appendGrid v1.3.4
* https://appendgrid.apphb.com/
*
* Copyright 2014 Albert L.
* Dual licensed under the LGPL (http://www.gnu.org/licenses/lgpl.html)
* and MIT (http://www.opensource.org/licenses/mit-license.php) licenses.
*
* Depends:
* jQuery v1.9.1+
* jquery UI v1.10.2+
*/
(function ($) {
    // The default initial options.
    var _defaultInitOptions = {
        // The text as table caption, set null to disable caption generation.
        caption: null,
        // The total number of empty rows generated when init the grid. This will be ignored if `initData` is assigned.
        initRows: 3,
        // An array of data to be filled after initialized the grid.
        initData: null,
        // Array of column options.
        columns: null,
        // Labels or messages used in grid.
        i18n: null,
        // The ID prefix of controls generated inside the grid. Table ID will be used if not defined.
        idPrefix: null,
        // Enable row dragging by using jQuery UI sortable on grid rows.
        rowDragging: false,
        // Hide the buttons at the end of rows or bottom of grid.
        hideButtons: null,
        // Hide the row number column.
        hideRowNumColumn: false,
        // Generate row buttom column in the front of input columns.
        rowButtonsInFront: false,
        // The extra class names for buttons.
        buttonClasses: null,
        // Adding extra button(s) at the end of rows.
        customRowButtons: null,
        // Adding extra button(s) at the bottom of grid.
        customFooterButtons: null,
        // The callback function to be triggered after data loaded to grid.
        dataLoaded: null,
        // The callback function to be triggered after new row appended.
        afterRowAppended: null,
        // The callback function to be triggered after new row inserted.
        afterRowInserted: null,
        // The callback function to be triggered after grid row swapped.
        afterRowSwapped: null,
        // The callback function to be triggered before grid row remove.
        beforeRowRemove: null,
        // The callback function to be triggered after grid row removed.
        afterRowRemoved: null
    };
    // Default column options.
    var _defaultColumnOptions = {
        // Type of column control.
        type: 'text',
        // Name of column.
        name: null,
        // Default value.
        value: null,
        // Display text on the header section.
        display: null,
        // Extra CSS setting to be added to display text.
        displayCss: null,
        // The `colspan` setting on the column header.
        headerSpan: 1,
        // Extra CSS setting to be added to the control container table cell.
        cellCss: null,
        // Extra attributes to be added to the control.
        ctrlAttr: null,
        // Extra properties to be added to the control.
        ctrlProp: null,
        // Extra CSS to be added to the control.
        ctrlCss: null,
        // Extra name of class to be added to the control.
        ctrlClass: null,
        // The available option for building `select` type control.
        ctrlOptions: null,
        // Options for initalize jQuery UI widget.
        uiOption: null,
        // Options for initalize jQuery UI tooltip.
        uiTooltip: null,
        // Callback function to build custom type control.
        customBuilder: null,
        // Callback function to get control value.
        customGetter: null,
        // Callback function to set control value.
        customSetter: null,
        // The `OnClick` event callback of control.
        onClick: null,
        // The `OnChange` event callback of control.
        onChange: null
    };
    var _systemMessages = {
        noColumnInfo: 'Cannot initial grid without column information!',
        elemNotTable: 'Cannot initial grid on element other than TABLE!',
        notInit: '`appendGrid` does not initialized',
        getValueMultiGrid: 'Cannot get values on multiple grid',
        notSupportMethod: 'Method is not supported by `appendGrid`: '
    };
    var _defaultTextResources = {
        append: 'Thêm sản phẩm',
        removeLast: 'Xóa',
        insert: 'Thêm mới',
        remove: 'Xóa',
        moveUp: 'Lên trên',
        moveDown: 'Xuống dưới',
        rowDrag: 'Sắp xếp',
        rowEmpty: 'Chưa có sản phẩm nào trong kho'
    };
    var _defaultButtonClasses = { append: null, removeLast: null, insert: null, remove: null, moveUp: null, moveDown: null, rowDrag: null };
    var _defaultHideButtons = { append: false, removeLast: false, insert: false, remove: false, moveUp: false, moveDown: false };
    var _methods = {
        init: function (options) {
            var target = this;
            var tbWhole, tbHead, tbBody, tbFoot, tbRow, tbCell;
            var tbHeadCellRowNum, tbHeadCellRowButton;
            if (target.length > 0) {
                // Check mandatory paramters included               
                // Check target element is table or not
                tbWhole = target[0];
                if (isEmpty(tbWhole.tagName) || tbWhole.tagName != 'TABLE') {
                    alert(_systemMessages.elemNotTable);
                    return target;
                }
                // Generate settings
                var settings = $.extend({}, _defaultInitOptions, options);
                // Add internal settings
                $.extend(settings, {
                    //The UniqueIndex accumulate counter.
                    _uniqueIndex: 0,
                    // The row order array.
                    _rowOrder: [],
                    // Indicate data is loaded or not.
                    _isDataLoaded: false,
                    // Visible column count for internal calculation.
                    _visibleCount: 0,
                    // Total colSpan count after excluding `hideRowNumColumn` and not generating last column.
                    _finalColSpan: 0,
                    // Indicate to hide last column or not
                    _hideLastColumn: false
                });
                // Labels or messages used in grid.
                if ($.isPlainObject(options.i18n))
                    settings._i18n = $.extend({}, _defaultTextResources, options.i18n);
                else
                    settings._i18n = $.extend({}, _defaultTextResources);
                // The extra class names for buttons.
                if ($.isPlainObject(options.buttonClasses))
                    settings._buttonClasses = $.extend({}, _defaultButtonClasses, options.buttonClasses);
                else
                    settings._buttonClasses = $.extend({}, _defaultButtonClasses);
                // Make sure the `hideButtons` setting defined
                if ($.isPlainObject(options.hideButtons))
                    settings.hideButtons = $.extend({}, _defaultHideButtons, options.hideButtons);
                else
                    settings.hideButtons = $.extend({}, _defaultHideButtons);
                // Check `idPrefix` is defined
                if (isEmpty(settings.idPrefix)) {
                    // Check table ID defined
                    if (isEmpty(tbWhole.id) || tbWhole.id == '') {
                        // Generate an ID using current time
                        settings.idPrefix = 'ag' + new Date().getTime();
                    }
                    else {
                        settings.idPrefix = tbWhole.id;
                    }
                }
                // Create thead and tbody
                tbHead = document.createElement('thead');
                tbHead.className = 'ui-widget-header';
                tbBody = document.createElement('tbody');
                tbBody.className = 'ui-widget-content';
                tbFoot = document.createElement('tfoot');
                tbFoot.className = 'ui-widget-header';
                // Remove existing content and append new thead and tbody
                $(tbWhole).empty().addClass('appendGrid ui-widget').append(tbHead, tbBody, tbFoot);
                // Handle header row
                tbRow = tbHead.insertRow(-1);
                if (!settings.hideRowNumColumn) {
                    tbHeadCellRowNum = tbRow.insertCell(-1);
                    tbHeadCellRowNum.className = 'ui-widget-header';
                }
                // Prepare column information and add column header
                var pendingSkipCol = 0;
                for (var z = 0; z < settings.columns.length; z++) {
                    // Assign default setting
                    var columnOpt = $.extend({}, _defaultColumnOptions, settings.columns[z]);
                    settings.columns[z] = columnOpt;
                    // Skip hidden
                    if (settings.columns[z].type != 'hidden') {
                        settings._visibleCount++;
                        // Check skip header colSpan
                        if (pendingSkipCol == 0) {
                            tbCell = tbRow.insertCell(-1);
                            tbCell.className = 'ui-widget-header';
                            $(tbCell).text(settings.columns[z].display);
                            if (settings.columns[z].displayCss) $(tbCell).css(settings.columns[z].displayCss);
                            if (settings.columns[z].headerSpan > 1) {
                                $(tbCell).attr('colSpan', settings.columns[z].headerSpan);
                                pendingSkipCol = settings.columns[z].headerSpan - 1;
                            }
                        } else {
                            pendingSkipCol--;
                        }
                    }
                }
                // Check to hide last column or not
                if (settings.hideButtons.insert && settings.hideButtons.remove
                        && settings.hideButtons.moveUp && settings.hideButtons.moveDown
                        && (!$.isArray(settings.customRowButtons) || settings.customRowButtons.length == 0)) {
                    settings._hideLastColumn = true;
                }
                // Calculate the `_finalColSpan` value
                settings._finalColSpan = settings._visibleCount;
                if (!settings.hideRowNumColumn) settings._finalColSpan++;
                if (!settings._hideLastColumn) settings._finalColSpan++;
                // Generate last column header if needed
                if (!settings._hideLastColumn) {
                    if (settings.rowButtonsInFront) {
                        if (settings.hideRowNumColumn) {
                            tbHeadCellRowButton = tbRow.insertCell(0);
                        } else {
                            tbHeadCellRowNum.colSpan = 2;
                            tbHeadCellRowButton = tbHeadCellRowNum;
                        }
                    } else {
                        tbHeadCellRowButton = tbRow.insertCell(-1);
                    }
                    tbHeadCellRowButton.className = 'ui-widget-header';
                }
                // Add caption when defined
                if (settings.caption) {
                    tbRow = tbHead.insertRow(0);
                    tbCell = tbRow.insertCell(-1);
                    tbCell.className = 'ui-state-active caption';
                    tbCell.colSpan = settings._finalColSpan;
                    $(tbCell).text(settings.caption);
                }
                // Handle footer row
                tbRow = tbFoot.insertRow(-1);
                tbCell = tbRow.insertCell(-1);
                tbCell.colSpan = settings._finalColSpan;
                $('<input/>').attr({
                    type: 'hidden',
                    id: settings.idPrefix + '_rowOrder',
                    name: settings.idPrefix + '_rowOrder'
                }).appendTo(tbCell);
                // Make row invisible if all buttons are hidden
                if (settings.hideButtons.append && settings.hideButtons.removeLast
                        && (!$.isArray(settings.customFooterButtons) || settings.customFooterButtons.length == 0)) {
                    tbRow.style.display = 'none';
                } else {
                    if (!settings.hideButtons.append) {
                        $('<button/>').addClass('append', settings._buttonClasses.append).attr({ type: 'button', title: settings._i18n.append })
                        .button({ icons: { primary: 'ui-icon-plusthick' }, text: false }).click(function () {
                            insertRow(tbWhole, 1, null, null);
                        }).appendTo(tbCell);
                    }
                    if (!settings.hideButtons.removeLast) {
                        $('<button/>').addClass('removeLast', settings._buttonClasses.removeLast).attr({ type: 'button', title: settings._i18n.removeLast })
                        .button({ icons: { primary: 'ui-icon-closethick' }, text: false }).click(function () {
                            removeRow(tbWhole, null, this.value, false);
                        }).appendTo(tbCell);
                    }
                    if (settings.customFooterButtons && settings.customFooterButtons.length) {
                        // Add front buttons
                        for (var y = settings.customFooterButtons.length - 1; y >= 0; y--) {
                            var buttonCfg = settings.customFooterButtons[y];
                            if (buttonCfg && buttonCfg.uiButton && buttonCfg.click && buttonCfg.atTheFront) {
                                $(tbCell).prepend(makeCustomBottomButton(tbWhole, buttonCfg));
                            }
                        }
                        // Add end buttons
                        for (var y = 0; y < settings.customFooterButtons.length; y++) {
                            var buttonCfg = settings.customFooterButtons[y];
                            if (buttonCfg && buttonCfg.uiButton && buttonCfg.click && !buttonCfg.atTheFront) {
                                $(tbCell).append(makeCustomBottomButton(tbWhole, buttonCfg));
                            }
                        }
                    }
                }
                // Enable dragging
                if (settings.rowDragging) {
                    $(tbBody).sortable({
                        axis: 'y',
                        containment: tbWhole,
                        handle: '.rowDrag',
                        helper: function (e, tr) {
                            var org = tr.children();
                            var helper = tr.clone();
                            helper.children().each(function (index) {
                                $(this).width(org.eq(index).width());
                            });
                            return helper;
                        },
                        update: function (event, ui) {
                            var uniqueIndex = ui.item[0].id.substring(ui.item[0].id.lastIndexOf('_') + 1);
                            var tbRowIndex = ui.item[0].rowIndex - $('tr', tbHead).length;
                            gridRowDragged(tbWhole, ui.originalPosition.top > ui.position.top, uniqueIndex, tbRowIndex);
                        }
                    });
                }
                // Save options
                $(tbWhole).data('appendGrid', settings);
                if ($.isArray(options.initData)) {
                    // Load data if initData is array
                    loadData(tbWhole, options.initData, true);
                } else {
                    // Add empty rows
                    $(tbWhole).appendGrid('appendRow', settings.initRows);
                }
                // Show no rows in grid
                if (settings._rowOrder.length == 0) {
                    var empty = $('<td></td>').text(settings._i18n.rowEmpty).attr('colspan', settings._finalColSpan);
                    $('tbody', tbWhole).append($('<tr></tr>').addClass('empty').append(empty));
                }
            }
            return target;
        },
        isReady: function () {
            // Check the appendGrid is initialized or not
            var target = this, result = false;
            if (target.length > 0) {
                var settings = target.first().data('appendGrid');
                if (settings) {
                    result = true;
                }
            }
            return result;
        },
        isDataLoaded: function () {
            // Check the grid data is loaded by `load` method or `initData` parameter or not
            var target = this, result = null;
            if (this.length == 1) {
                var settings = target.data('appendGrid');
                if (settings) {
                    return settings._isDataLoaded;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        },
        load: function (records) {
            var target = this;
            if (target.length > 0) {
                if (records != null && records.length > 0) {
                    loadData(target[0], records, false);
                } else {
                    emptyGrid(target[0]);
                }
            }
            return target;
        },
        appendRow: function (numOfRowOrRowArray) {
            return this.appendGrid('insertRow', numOfRowOrRowArray);
        },
        insertRow: function (numOfRowOrRowArray, rowIndex, callerUniqueIndex) {
            var target = this;
            if (target.length > 0) {
                var tbWhole = target[0], insertResult = null;
                var settings = $(tbWhole).data('appendGrid');
                if (!settings) {
                    alert(_systemMessages.notInit);
                }
                else if (($.isArray(numOfRowOrRowArray) && numOfRowOrRowArray.length > 0) || ($.isNumeric(numOfRowOrRowArray) && numOfRowOrRowArray > 0)) {
                    // Define variables
                    insertResult = insertRow(tbWhole, numOfRowOrRowArray, rowIndex, callerUniqueIndex);
                    // Reorder sequence as needed
                    if ($.isNumeric(rowIndex) || $.isNumeric(callerUniqueIndex)) {
                        // Sort sequence
                        sortSequence(tbWhole, insertResult.rowIndex);
                        // Move focus
                        var insertUniqueIndex = settings._rowOrder[insertResult.addedRows[0]];
                        $('#' + settings.idPrefix + '_Insert_' + insertUniqueIndex, tbWhole).focus();
                    }
                }
            }
            return target;
        },
        removeRow: function (rowIndex, uniqueIndex) {
            var target = this;
            if (target.length > 0) {
                var tbWhole = target[0];
                var settings = $(tbWhole).data('appendGrid');
                if (!settings) {
                    alert(_systemMessages.notInit);
                }
                else if (settings._rowOrder.length > 0) {
                    removeRow(tbWhole, rowIndex, uniqueIndex, true);
                }
            }
            return target;
        },
        emptyGrid: function () {
            var target = this;
            if (target.length > 0) {
                var tbWhole = target[0];
                var settings = $(tbWhole).data('appendGrid');
                if (!settings) {
                    alert(_systemMessages.notInit);
                }
                else {
                    emptyGrid(tbWhole);
                }
            }
            return target;
        },
        moveUpRow: function (rowIndex, uniqueIndex) {
            var target = this, tbodyIndex = -1;
            if (target.length > 0) {
                var tbWhole = target[0], tbBody, trTarget, trSwap, swapSeq;
                var settings = $(tbWhole).data('appendGrid');
                if (!settings) {
                    alert(_systemMessages.notInit);
                }
                else {
                    var oldIndex = null;
                    tbBody = tbWhole.getElementsByTagName('tbody')[0];
                    if ($.isNumeric(rowIndex) && rowIndex > 0 && rowIndex < settings._rowOrder.length) {
                        oldIndex = rowIndex;
                        uniqueIndex = settings._rowOrder[rowIndex];
                        trTarget = document.getElementById(settings.idPrefix + '_Row_' + uniqueIndex, tbWhole);
                    } else if ($.isNumeric(uniqueIndex)) {
                        oldIndex = findRowIndex(uniqueIndex, settings);
                        trTarget = document.getElementById(settings.idPrefix + '_Row_' + uniqueIndex, tbWhole);
                    }
                    if (oldIndex != null && oldIndex > 0) {
                        // Get row to swap
                        trSwap = document.getElementById(settings.idPrefix + '_Row_' + settings._rowOrder[oldIndex - 1], tbWhole);
                        // Remove current row
                        tbBody.removeChild(trTarget);
                        // Insert before the above row
                        tbBody.insertBefore(trTarget, trSwap);
                        // Update rowOrder
                        settings._rowOrder[oldIndex] = settings._rowOrder[oldIndex - 1];
                        settings._rowOrder[oldIndex - 1] = uniqueIndex;
                        // Update row label
                        swapSeq = $('td.first', trSwap).html();
                        $('td.first', trSwap).html($('td.first', trTarget).html());
                        $('td.first', trTarget).html(swapSeq)
                        // Save setting
                        saveSetting(tbWhole, settings);
                        // Change focus
                        $('td.last button.moveUp', trTarget).removeClass('ui-state-hover').blur();
                        $('td.last button.moveUp', trSwap).focus();
                        // Trigger event
                        if (settings.afterRowSwapped) {
                            settings.afterRowSwapped(tbWhole, oldIndex, oldIndex - 1);
                        }
                    }
                }
            }
            return target;
        },
        moveDownRow: function (rowIndex, uniqueIndex) {
            var target = this, tbodyIndex = -1;
            if (target.length > 0) {
                var tbWhole = target[0], tbBody, trTarget, trSwap, swapSeq;
                var settings = $(tbWhole).data('appendGrid');
                if (!settings) {
                    alert(_systemMessages.notInit);
                }
                else {
                    var oldIndex = null;
                    tbBody = tbWhole.getElementsByTagName('tbody')[0];
                    if ($.isNumeric(rowIndex) && rowIndex >= 0 && rowIndex < settings._rowOrder.length - 1) {
                        oldIndex = rowIndex;
                        uniqueIndex = settings._rowOrder[rowIndex];
                        trTarget = document.getElementById(settings.idPrefix + '_Row_' + uniqueIndex, tbWhole);
                    } else if ($.isNumeric(uniqueIndex)) {
                        oldIndex = findRowIndex(uniqueIndex, settings);
                        trTarget = document.getElementById(settings.idPrefix + '_Row_' + uniqueIndex, tbWhole);
                    }
                    if (oldIndex != null && oldIndex != settings._rowOrder.length - 1) {
                        // Get row to swap
                        trSwap = document.getElementById(settings.idPrefix + '_Row_' + settings._rowOrder[oldIndex + 1], tbWhole);
                        // Remove current row
                        tbBody.removeChild(trSwap);
                        // Insert before the above row
                        tbBody.insertBefore(trSwap, trTarget);
                        // Update rowOrder
                        settings._rowOrder[oldIndex] = settings._rowOrder[oldIndex + 1];
                        settings._rowOrder[oldIndex + 1] = uniqueIndex;
                        // Update row label
                        swapSeq = $('td.first', trSwap).html();
                        $('td.first', trSwap).html($('td.first', trTarget).html());
                        $('td.first', trTarget).html(swapSeq)
                        // Save setting
                        saveSetting(tbWhole, settings);
                        // Change focus
                        $('td.last button.moveDown', trTarget).removeClass('ui-state-hover').blur();
                        $('td.last button.moveDown', trSwap).focus();
                        // Trigger event
                        if (settings.afterRowSwapped) {
                            settings.afterRowSwapped(tbWhole, oldIndex, oldIndex + 1);
                        }
                    }
                }
            }
            return target;
        },
        getRowCount: function () {
            var target = this;
            if (target.length > 0) {
                var settings = target.data('appendGrid');
                if (settings) {
                    return settings._rowOrder.length;
                }
                else {
                    alert(_systemMessages.notInit);
                }
            }
            else {
                alert(_systemMessages.getValueMultiGrid);
            }
            return null;
        },
        getUniqueIndex: function (rowIndex) {
            var target = this;
            if (target.length > 0 && rowIndex >= 0) {
                var settings = target.data('appendGrid');
                if (settings) {
                    if (rowIndex < settings._rowOrder.length) {
                        return settings._rowOrder[rowIndex];
                    }
                }
                else {
                    alert(_systemMessages.notInit);
                }
            }
            return null;
        },
        getRowIndex: function (uniqueIndex) {
            var target = this;
            if (target.length > 0) {
                var settings = target.data('appendGrid');
                if (settings) {
                    for (var z = 0; z < settings._rowOrder.length; z++) {
                        if (settings._rowOrder[z] == uniqueIndex) {
                            return z;
                        }
                    }
                    return null;
                }
                else {
                    alert(_systemMessages.notInit);
                }
            }
            return null;
        },
        getRowValue: function (rowIndex, uniqueIndex, loopIndex) {
            var target = this, result = null;
            if (target.length > 0) {
                var settings = target.data('appendGrid');
                if (settings) {
                    if ($.isNumeric(rowIndex) && rowIndex >= 0 && rowIndex < settings._rowOrder.length) {
                        uniqueIndex = settings._rowOrder[rowIndex];
                    }
                    if (!isEmpty(uniqueIndex)) {
                        result = getRowValue(settings, uniqueIndex, loopIndex);
                    }
                }
                else {
                    alert(_systemMessages.notInit);
                }
            }
            return result;
        },
        getAllValue: function (objectMode) {
            var target = this, result = null, rowValue;
            if (target.length > 0) {
                var settings = $(target).data('appendGrid');
                if (settings) {
                    // Prepare result based on objectMode setting
                    result = objectMode ? {} : [];
                    // Process on each rows
                    for (var z = 0; z < settings._rowOrder.length; z++) {
                        if (objectMode) {
                            rowValue = getRowValue(settings, settings._rowOrder[z], z);
                            $.extend(result, rowValue)
                        } else {
                            rowValue = getRowValue(settings, settings._rowOrder[z]);
                            result.push(rowValue);
                        }
                    }
                    if (objectMode) {
                        result['_RowCount'] = settings._rowOrder.length;
                    }
                }
            }
            return result;
        },
        getCtrlValue: function (name, rowIndex) {
            var target = this;
            if (target.length > 0) {
                settings = target.data('appendGrid');
                if (settings && rowIndex >= 0 && rowIndex < settings._rowOrder.length) {
                    for (var z = 0; z < settings.columns.length; z++) {
                        if (settings.columns[z].name === name) {
                            return getCtrlValue(settings, z, settings._rowOrder[rowIndex]);
                        }
                    }
                }
            }
            return null;
        },
        setCtrlValue: function (name, rowIndex, value) {
            var target = this;
            if (target.length > 0) {
                var tbWhole = this, settings = $(this).data('appendGrid');
                if (settings && rowIndex >= 0 && rowIndex < settings._rowOrder.length) {
                    for (var z = 0; z < settings.columns.length; z++) {
                        if (settings.columns[z].name == name) {
                            setCtrlValue(settings, z, settings._rowOrder[rowIndex], value);
                            break;
                        }
                    }
                }
            }
            return target;
        },
        getCellCtrl: function (name, uniqueIndex) {
            var target = this, result = null;
            if (target.length == 1) {
                settings = target.data('appendGrid');
                if (!settings) {
                    alert(_systemMessages.notInit);
                }
                else {
                    for (var z = 0; z < settings.columns.length; z++) {
                        if (settings.columns[z].name === name) {
                            return getCellCtrl(settings.columns[z].type, settings.idPrefix, name, uniqueIndex);
                            break;
                        }
                    }
                }
            }
            return null;
        },
        getCellCtrlByRowIndex: function (name, rowIndex) {
            var target = this, result = null;
            if (target.length == 1) {
                settings = target.data('appendGrid');
                if (!settings) {
                    alert(_systemMessages.notInit);
                }
                else {
                    if (rowIndex >= 0 && rowIndex < settings._rowOrder.length) {
                        var uniqueIndex = settings._rowOrder[rowIndex];
                        for (var z = 0; z < settings.columns.length; z++) {
                            if (settings.columns[z].name === name) {
                                return getCellCtrl(settings.columns[z].type, settings.idPrefix, name, uniqueIndex);
                            }
                        }
                    }
                }
            }
            return null;
        },
        setCellCtrlByRowIndex: function (name, rowIndex, value) {
            var target = this, result = null;
            if (target.length == 1) {
                settings = target.data('appendGrid');
                if (!settings) {
                    alert(_systemMessages.notInit);
                }
                else {
                    if (rowIndex >= 0 && rowIndex < settings._rowOrder.length) {
                        var uniqueIndex = settings._rowOrder[rowIndex];
                        for (var z = 0; z < settings.columns.length; z++) {
                            if (settings.columns[z].name === name) {
                                return setCellCtrl(settings.columns[z].type, settings.idPrefix, name, uniqueIndex, value);
                            }
                        }
                    }
                }
            }
            return null;
        },
        getRowOrder: function () {
            var target = this, result = null;
            if (this.length == 1) {
                var settings = target.data('appendGrid');
                if (settings) {
                    result = settings._rowOrder.slice();
                }
                else {
                    alert(_systemMessages.notInit);
                }
            }
            else {
                alert(_systemMessages.getValueMultiGrid);
            }
            return result;
        }
    };
    function insertRow(tbWhole, numOfRowOrRowArray, rowIndex, callerUniqueIndex) {
        // Define variables
        var settings = $(tbWhole).data('appendGrid');
        var addedRows = [], parentIndex = null, uniqueIndex, ctrl, hidden = [];
        var tbHead = tbWhole.getElementsByTagName('thead')[0];
        var tbBody = tbWhole.getElementsByTagName('tbody')[0];
        // Check number of row to be inserted
        var numOfRow = numOfRowOrRowArray, loadData = false;
        if ($.isArray(numOfRowOrRowArray)) {
            numOfRow = numOfRowOrRowArray.length;
            loadData = true;
        }
        // Check parent row
        if ($.isNumeric(callerUniqueIndex)) {
            for (var z = 0; z < settings._rowOrder.length; z++) {
                if (settings._rowOrder[z] == callerUniqueIndex) {
                    rowIndex = z;
                    if (z != 0) parentIndex = z - 1;
                    break;
                }
            }
        }
        else if ($.isNumeric(rowIndex)) {
            if (rowIndex >= settings._rowOrder.length) {
                rowIndex = null;
            } else {
                parentIndex = rowIndex - 1;
            }
        }
        else if (settings._rowOrder.length != 0) {
            rowIndex = null;
            parentIndex = settings._rowOrder.length - 1;
        }
        // Remove empty row
        if (settings._rowOrder.length == 0) {
            $('tr.empty', tbWhole).remove();
        }
        // Add total number of row
        for (var z = 0; z < numOfRow; z++) {
            // Update variables
            settings._uniqueIndex++;
            uniqueIndex = settings._uniqueIndex;
            hidden.length = 0;
            // Check row insert index
            if ($.isNumeric(rowIndex)) {
                settings._rowOrder.splice(rowIndex, 0, uniqueIndex);
                tbRow = tbBody.insertRow(rowIndex);
                addedRows.push(rowIndex);
            }
            else {
                settings._rowOrder.push(uniqueIndex);
                tbRow = tbBody.insertRow(-1);
                addedRows.push(settings._rowOrder.length - 1);
            }
            tbRow.id = settings.idPrefix + '_Row_' + uniqueIndex;
            $(tbRow).data('appendGrid', uniqueIndex);
            // Add row number
            if (!settings.hideRowNumColumn) {
                tbCell = tbRow.insertCell(-1);
                $(tbCell).addClass('ui-widget-content first').text(settings._rowOrder.length);
            }
            // Process on each columns
            for (var y = 0; y < settings.columns.length; y++) {
                // Skip hidden
                if (settings.columns[y].type == 'hidden') {
                    hidden.push(y);
                    continue;
                }
                // Insert cell
                tbCell = tbRow.insertCell(-1);
                tbCell.className = 'ui-widget-content';
                if (settings.columns[y].cellCss != null) $(tbCell).css(settings.columns[y].cellCss);
                // Check control type
                ctrl = null;
                if (settings.columns[y].type == 'custom') {
                    if (typeof (settings.columns[y].customBuilder) == 'function') {
                        ctrl = settings.columns[y].customBuilder(tbCell, settings.idPrefix, settings.columns[y].name, uniqueIndex);
                    }
                }
                else if (settings.columns[y].type == 'select') {
                    ctrl = document.createElement('select');
                    ctrl.id = settings.idPrefix + '_' + settings.columns[y].name + '_' + uniqueIndex;
                    ctrl.name = ctrl.id;
                    // Build option list
                    if ($.isArray(settings.columns[y].ctrlOptions)) {
                        // For array type option list
                        if (settings.columns[y].ctrlOptions.length > 0) {
                            if ($.isPlainObject(settings.columns[y].ctrlOptions[0])) {
                                for (var x = 0; x < settings.columns[y].ctrlOptions.length; x++) {
                                    ctrl.options[ctrl.options.length] = new Option(settings.columns[y].ctrlOptions[x].label, settings.columns[y].ctrlOptions[x].value);
                                }
                            }
                            else {
                                for (var x = 0; x < settings.columns[y].ctrlOptions.length; x++) {
                                    ctrl.options[ctrl.options.length] = new Option(settings.columns[y].ctrlOptions[x], settings.columns[y].ctrlOptions[x]);
                                }
                            }
                        }
                    }
                    else if ($.isPlainObject(settings.columns[y].ctrlOptions)) {
                        // For plain object type option list
                        for (var x in settings.columns[y].ctrlOptions) {
                            ctrl.options[ctrl.options.length] = new Option(settings.columns[y].ctrlOptions[x], x);
                        }
                    }
                    else if (typeof (settings.columns[y].ctrlOptions) == 'string') {
                        // For string type option list
                        var arrayOpt = settings.columns[y].ctrlOptions.split(';');
                        for (var x = 0; x < arrayOpt.length; x++) {
                            var eqIndex = arrayOpt[x].indexOf(':');
                            if (-1 == eqIndex) {
                                ctrl.options[ctrl.options.length] = new Option(arrayOpt[x], arrayOpt[x]);
                            } else {
                                ctrl.options[ctrl.options.length] = new Option(arrayOpt[x].substring(eqIndex + 1, arrayOpt[x].length), arrayOpt[x].substring(0, eqIndex));
                            }
                        }
                    }
                    tbCell.appendChild(ctrl);
                }
                else if (settings.columns[y].type == 'checkbox') {
                    ctrl = document.createElement('input');
                    ctrl.type = 'checkbox';
                    ctrl.id = settings.idPrefix + '_' + settings.columns[y].name + '_' + uniqueIndex;
                    ctrl.name = ctrl.id;
                    ctrl.value = 1;
                    tbCell.appendChild(ctrl);
                    tbCell.style.textAlign = 'center';
                }
                else if (settings.columns[y].type == 'textarea') {
                    ctrl = document.createElement('textarea');
                    ctrl.id = settings.idPrefix + '_' + settings.columns[y].name + '_' + uniqueIndex;
                    ctrl.name = ctrl.id;
                    tbCell.appendChild(ctrl);
                }
                else if (-1 != settings.columns[y].type.search(/^(color|date|datetime|datetime\-local|email|month|number|range|search|tel|time|url|week)$/)) {
                    ctrl = document.createElement('input');
                    try {
                        ctrl.type = settings.columns[y].type;
                    }
                    catch (err) { /* Not supported type */ }
                    ctrl.id = settings.idPrefix + '_' + settings.columns[y].name + '_' + uniqueIndex;
                    ctrl.name = ctrl.id;
                    tbCell.appendChild(ctrl);
                }
                else {
                    // Generate text input
                    ctrl = document.createElement('input');
                    ctrl.type = 'text';
                    ctrl.id = settings.idPrefix + '_' + settings.columns[y].name + '_' + uniqueIndex;
                    ctrl.name = ctrl.id;
                    tbCell.appendChild(ctrl);
                    // Handle UI widget
                    if (settings.columns[y].type == 'ui-datepicker') {
                        $(ctrl).datepicker(settings.columns[y].uiOption);
                    } else if (settings.columns[y].type == 'ui-spinner') {
                        $(ctrl).spinner(settings.columns[y].uiOption);
                    } else if (settings.columns[y].type == 'ui-autocomplete') {
                        $(ctrl).autocomplete(settings.columns[y].uiOption);
                    }
                }
                // Add extra control properties
                if (settings.columns[y].type != 'custom') {
                    // Add control attributes as needed
                    if (settings.columns[y].ctrlAttr != null) $(ctrl).attr(settings.columns[y].ctrlAttr);
                    // Add control properties as needed
                    if (settings.columns[y].ctrlProp != null) $(ctrl).prop(settings.columns[y].ctrlProp);
                    // Add control CSS as needed
                    if (settings.columns[y].ctrlCss != null) $(ctrl).css(settings.columns[y].ctrlCss);
                    // Add control class as needed
                    if (settings.columns[y].ctrlClass != null) $(ctrl).addClass(settings.columns[y].ctrlClass);
                    // Add jQuery UI tooltip as needed
                    if (settings.columns[y].uiTooltip) $(ctrl).tooltip(settings.columns[y].uiTooltip);
                    // Add control events as needed
                    if (typeof (settings.columns[y].onClick) == 'function') {
                        $(ctrl).click({ caller: tbWhole, callback: settings.columns[y].onClick, uniqueIndex: uniqueIndex }, function (evt) {
                            evt.data.callback(evt, $(evt.data.caller).appendGrid('getRowIndex', evt.data.uniqueIndex));
                        });
                    }
                    if (typeof (settings.columns[y].onChange) == 'function') {
                        $(ctrl).change({ caller: tbWhole, callback: settings.columns[y].onChange, uniqueIndex: uniqueIndex }, function (evt) {
                            evt.data.callback(evt, $(evt.data.caller).appendGrid('getRowIndex', evt.data.uniqueIndex));
                        });
                    }
                }
                if (loadData) {
                    // Load data if needed
                    setCtrlValue(settings, y, uniqueIndex, numOfRowOrRowArray[z][settings.columns[y].name]);
                } else if (!isEmpty(settings.columns[y].value)) {
                    // Set default value
                    setCtrlValue(settings, y, uniqueIndex, settings.columns[y].value);
                }
            }
            // Add button cell if needed
            if (!settings._hideLastColumn || settings.columns.length > settings._visibleCount) {
                if (!settings.rowButtonsInFront) {
                    tbCell = tbRow.insertCell(-1);
                } else if (!settings.hideRowNumColumn) {
                    tbCell = tbRow.insertCell(1);
                } else {
                    tbCell = tbRow.insertCell(0);
                }
                tbCell.className = 'ui-widget-content last';
                if (settings._hideLastColumn) tbCell.style.display = 'none';
                // Add standard buttons
                if (!settings.hideButtons.insert) {
                    $(tbCell).append($('<button/>').addClass('insert', settings._buttonClasses.insert).val(uniqueIndex)
                        .attr({ id: settings.idPrefix + '_Insert_' + uniqueIndex, type: 'button', title: settings._i18n.insert, tabindex: -1 })
                        .button({ icons: { primary: 'ui-icon-arrowreturnthick-1-w' }, text: false }).click(function () {
                            $(tbWhole).appendGrid('insertRow', 1, null, this.value);
                        }));
                }
                if (!settings.hideButtons.remove) {
                    $(tbCell).append($('<button/>').addClass('remove', settings._buttonClasses.remove).val(uniqueIndex)
                        .attr({ id: settings.idPrefix + '_Delete_' + uniqueIndex, type: 'button', title: settings._i18n.remove, tabindex: -1 })
                        .button({ icons: { primary: 'ui-icon-trash' }, text: false }).click(function () {
                            removeRow(tbWhole, null, this.value, false);
                        }));
                }
                if (!settings.hideButtons.moveUp) {
                    $(tbCell).append($('<button/>').addClass('moveUp', settings._buttonClasses.moveUp).val(uniqueIndex)
                        .attr({ id: settings.idPrefix + '_MoveUp_' + uniqueIndex, type: 'button', title: settings._i18n.moveUp, tabindex: -1 })
                        .button({ icons: { primary: 'ui-icon-arrowthick-1-n' }, text: false }).click(function () {
                            $(tbWhole).appendGrid('moveUpRow', null, this.value);
                        }));
                }
                if (!settings.hideButtons.moveDown) {
                    $(tbCell).append($('<button/>').addClass('moveDown', settings._buttonClasses.moveDown).val(uniqueIndex)
                        .attr({ id: settings.idPrefix + '_MoveDown_' + uniqueIndex, type: 'button', title: settings._i18n.moveDown, tabindex: -1 })
                        .button({ icons: { primary: 'ui-icon-arrowthick-1-s' }, text: false }).click(function () {
                            $(tbWhole).appendGrid('moveDownRow', null, this.value);
                        }));
                }
                // Handle row dragging
                if (settings.rowDragging) {
                    $('<div/>').addClass('rowDrag ui-state-default ui-corner-all', settings._buttonClasses.rowDrag)
                        .attr('title', settings._i18n.rowDrag).append($('<div/>').addClass('ui-icon ui-icon-carat-2-n-s'))
                        .appendTo(tbCell);
                }
                // Add hidden
                for (var y = 0; y < hidden.length; y++) {
                    ctrl = document.createElement('input');
                    ctrl.id = settings.idPrefix + '_' + settings.columns[hidden[y]].name + '_' + uniqueIndex;
                    ctrl.name = ctrl.id;
                    ctrl.type = 'hidden';

                    if (loadData) {
                        // Load data if needed
                        ctrl.value = numOfRowOrRowArray[z][settings.columns[hidden[y]].name];
                    } else if (!isEmpty(settings.columns[hidden[y]].value)) {
                        // Set default value
                        ctrl.value = settings.columns[hidden[y]].value;
                    }
                    tbCell.appendChild(ctrl);
                }
                // Add extra buttons
                if (settings.customRowButtons && settings.customRowButtons.length) {
                    // Add front buttons
                    for (var y = settings.customRowButtons.length - 1; y >= 0; y--) {
                        var buttonCfg = settings.customRowButtons[y];
                        if (buttonCfg && buttonCfg.uiButton && buttonCfg.click && buttonCfg.atTheFront) {
                            $(tbCell).prepend(makeCustomRowButton(tbWhole, buttonCfg, uniqueIndex));
                        }
                    }
                    // Add end buttons
                    for (var y = 0; y < settings.customRowButtons.length; y++) {
                        var buttonCfg = settings.customRowButtons[y];
                        if (buttonCfg && buttonCfg.uiButton && buttonCfg.click && !buttonCfg.atTheFront) {
                            $(tbCell).append(makeCustomRowButton(tbWhole, buttonCfg, uniqueIndex));
                        }
                    }
                }
            }
        }
        // Save setting
        saveSetting(tbWhole, settings);
        // Trigger events
        if ($.isNumeric(rowIndex)) {
            if (typeof (settings.afterRowInserted) == 'function') {
                settings.afterRowInserted(tbWhole, parentIndex, addedRows);
            }
        }
        else {
            if (typeof (settings.afterRowAppended) == 'function') {
                settings.afterRowAppended(tbWhole, parentIndex, addedRows);
            }
        }
        // Return added rows' uniqueIndex
        return { addedRows: addedRows, parentIndex: parentIndex, rowIndex: rowIndex };
    }
    function makeCustomBottomButton(tbWhole, buttonCfg) {
        var exButton = $('<button/>').attr({ type: 'button', tabindex: -1 })
        .button(buttonCfg.uiButton).click({ tbWhole: tbWhole }, buttonCfg.click);
        if (buttonCfg.btnClass) exButton.addClass(buttonCfg.btnClass);
        if (buttonCfg.btnCss) exButton.css(buttonCfg.btnCss);
        if (buttonCfg.btnAttr) exButton.attr(buttonCfg.btnAttr);
        return exButton;
    }
    function makeCustomRowButton(tbWhole, buttonCfg, uniqueIndex) {
        var exButton = $('<button/>').val(uniqueIndex).attr({ type: 'button', tabindex: -1 })
        .button(buttonCfg.uiButton).click({ tbWhole: tbWhole, uniqueIndex: uniqueIndex }, function (evt) {
            var rowData = $(evt.data.tbWhole).appendGrid('getRowValue', null, evt.data.uniqueIndex);
            buttonCfg.click(evt, evt.data.uniqueIndex, rowData);
        });
        if (buttonCfg.btnClass) exButton.addClass(buttonCfg.btnClass);
        if (buttonCfg.btnCss) exButton.css(buttonCfg.btnCss);
        if (buttonCfg.btnAttr) exButton.attr(buttonCfg.btnAttr);
        return exButton;
    }
    function removeRow(tbWhole, rowIndex, uniqueIndex, force) {
        var settings = $(tbWhole).data('appendGrid');
        var tbBody = tbWhole.getElementsByTagName('tbody')[0];
        if ($.isNumeric(uniqueIndex)) {
            for (var z = 0; z < settings._rowOrder.length; z++) {
                if (settings._rowOrder[z] == uniqueIndex) {
                    rowIndex = z;
                    break;
                }
            }
        }
        if ($.isNumeric(rowIndex)) {
            // Remove middle row
            if (force || typeof (settings.beforeRowRemove) != 'function' || settings.beforeRowRemove(tbWhole, rowIndex)) {
                settings._rowOrder.splice(rowIndex, 1);
                tbBody.deleteRow(rowIndex);
                // Save setting
                saveSetting(tbWhole, settings);
                // Sort sequence
                sortSequence(tbWhole, rowIndex);
                // Trigger event
                if (typeof (settings.afterRowRemoved) == 'function') {
                    settings.afterRowRemoved(tbWhole, rowIndex);
                }
            }
        }
        else {
            // Remove last row
            if (force || typeof (settings.beforeRowRemove) != 'function' || settings.beforeRowRemove(tbWhole, settings._rowOrder.length - 1)) {
                uniqueIndex = settings._rowOrder.pop();
                tbBody.deleteRow(-1);
                // Save setting
                saveSetting(tbWhole, settings);
                // Trigger event
                if (typeof (settings.afterRowRemoved) == 'function') {
                    settings.afterRowRemoved(tbWhole, null);
                }
            }
        }
        // Add empty row
        if (settings._rowOrder.length == 0) {
            var empty = $('<td></td>').text(settings._i18n.rowEmpty).attr('colspan', settings._finalColSpan);
            $('tbody', tbWhole).append($('<tr></tr>').addClass('empty').append(empty));
        }
    }
    function emptyGrid(tbWhole) {
        // Load settings
        var settings = $(tbWhole).data('appendGrid');
        // Remove rows
        $('tbody', tbWhole).empty();
        settings._rowOrder.length = 0;
        settings._uniqueIndex = 0;
        // Save setting
        saveSetting(tbWhole, settings);
        // Add empty row
        if (settings._rowOrder.length == 0) {
            var empty = $('<td></td>').text(settings._i18n.rowEmpty).attr('colspan', settings._finalColSpan);
            $('tbody', tbWhole).append($('<tr></tr>').addClass('empty').append(empty));
        }
    }
    function sortSequence(tbWhole, startIndex) {
        var settings = $(tbWhole).data('appendGrid');
        if (!settings.hideRowNumColumn) {
            for (var z = startIndex; z < settings._rowOrder.length; z++) {
                $('#' + settings.idPrefix + '_Row_' + settings._rowOrder[z] + ' td.first', tbWhole).text(z + 1);
            }
        }
    }
    function loadData(tbWhole, records, isInit) {
        var tbBody, tbRow, tbCell, uniqueIndex, insertResult;
        var settings = $(tbWhole).data('appendGrid');
        if (settings) {
            // Clear existing content
            tbBody = tbWhole.getElementsByTagName('tbody')[0];
            $(tbBody).empty();
            settings._rowOrder.length = 0;
            settings._uniqueIndex = 0;
            // Check any records
            if (records != null && records.length) {
                // Add rows
                insertResult = insertRow(tbWhole, records.length, null, null);
                // Set data
                for (var r = 0; r < insertResult.addedRows.length; r++) {
                    for (var c = 0; c < settings.columns.length; c++) {
                        setCtrlValue(settings, c, settings._rowOrder[r], records[r][settings.columns[c].name]);
                    }
                }
            }
            // Save setting
            settings._isDataLoaded = true;
            if (isInit) settings.initData = null;
            $(tbWhole).data('appendGrid', settings);
            // Trigger data loaded event
            if (typeof (settings.dataLoaded) == 'function') {
                settings.dataLoaded(tbWhole);
            }
        }
    }
    function findRowIndex(uniqueIndex, settings) {
        for (var z = 0; z < settings._rowOrder.length; z++) {
            if (settings._rowOrder[z] == uniqueIndex) {
                return z;
            }
        }
        return null;
    }
    function isEmpty(value) {
        return typeof (value) == 'undefined' || value == null;
    }
    function getObjValue(obj, key) {
        if (!isEmpty(obj) && $.isPlainObject(obj) && !isEmpty(obj[key])) {
            return obj[key];
        }
        return null;
    }
    function saveSetting(tbWhole, settings) {
        $(tbWhole).data('appendGrid', settings);
        $('#' + settings.idPrefix + '_rowOrder', tbWhole).val(settings._rowOrder.join());
    }
    function getRowIndex(settings, uniqueIndex) {
        var rowIndex = null;
        for (var z = 0; z < settings._rowOrder.length; z++) {
            if (settings._rowOrder[z] == uniqueIndex) {
                return z;
            }
        }
        return rowIndex;
    }
    function getRowValue(settings, uniqueIndex, loopIndex) {
        var result = {}, keyName = null;
        for (var z = 0; z < settings.columns.length; z++) {
            keyName = settings.columns[z].name + (isEmpty(loopIndex) ? '' : '_' + loopIndex);
            result[keyName] = getCtrlValue(settings, z, uniqueIndex);
        }
        return result;
    }
    function getCtrlValue(settings, colIndex, uniqueIndex) { // type, idPrefix, columnName, uniqueIndex
        var ctrl = null, type = settings.columns[colIndex].type, columnName = settings.columns[colIndex].name;
        if (type == 'checkbox') {
            ctrl = getCellCtrl(type, settings.idPrefix, columnName, uniqueIndex);
            if (ctrl == null)
                return null;
            else
                return ctrl.checked ? 1 : 0;
        }
        else if (type == 'custom') {
            if (typeof (settings.columns[colIndex].customGetter) == 'function')
                return settings.columns[colIndex].customGetter(settings.idPrefix, columnName, uniqueIndex);
            else
                return null;
        }
        else {
            ctrl = getCellCtrl(type, settings.idPrefix, columnName, uniqueIndex);
            if (ctrl == null)
                return null;
            else
                return ctrl.value;
        }
    }
    function getCellCtrl(type, idPrefix, columnName, uniqueIndex) {
        return document.getElementById(idPrefix + '_' + columnName + '_' + uniqueIndex);
    }
    function setCtrlValue(settings, colIndex, uniqueIndex, data) {
        var type = settings.columns[colIndex].type;
        var columnName = settings.columns[colIndex].name;
        if (type == 'checkbox') {
            getCellCtrl(type, settings.idPrefix, columnName, uniqueIndex).checked = (data != null && data != 0);
        }
        else if (type == 'custom') {
            if (typeof (settings.columns[colIndex].customSetter) == 'function') {
                settings.columns[colIndex].customSetter(settings.idPrefix, columnName, uniqueIndex, data);
            }
        }
        else {
            getCellCtrl(type, settings.idPrefix, columnName, uniqueIndex).value = (data == null ? '' : data);
        }
    }
    function gridRowDragged(tbWhole, isMoveUp, uniqueIndex, tbRowIndex) {
        // Get setting
        var settings = $(tbWhole).data('appendGrid');
        // Find the start sorting index
        var startIndex = -1;
        for (var z = 0; z < settings._rowOrder.length; z++) {
            if (settings._rowOrder[z] == uniqueIndex) {
                if (isMoveUp) {
                    startIndex = tbRowIndex;
                    settings._rowOrder.splice(z, 1);
                    settings._rowOrder.splice(tbRowIndex, 0, uniqueIndex);
                } else {
                    startIndex = z;
                    settings._rowOrder.splice(tbRowIndex + 1, 0, uniqueIndex);
                    settings._rowOrder.splice(z, 1);
                }
                break;
            }
        }
        // Do re-order
        sortSequence(tbWhole, startIndex);
        // Save setting
        saveSetting(tbWhole, settings);
    }
    /// <summary>
    /// Initialize append grid or calling its methods.
    /// </summary>
    $.fn.appendGrid = function (params) {
        if (_methods[params]) {
            return _methods[params].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof (params) === 'object' || !params) {
            return _methods.init.apply(this, arguments);
        } else {
            $.error(_systemMessages.notSupportMethod + params);
        }
    };
})(jQuery);