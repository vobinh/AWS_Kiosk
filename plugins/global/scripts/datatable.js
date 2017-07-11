/***
Wrapper/Helper Class for datagrid based on jQuery Datatable Plugin
***/
var Datatable = function() {
    var sltCheckbox   = [];
    var nonsltCheckbox = [];
    var tableOptions;
    var dataTable;
    var table;
    var tableContainer;
    var tableWrapper;
    var tableInitialized = false;
    var ajaxParams = {};
    var the;

    var countSelectedRecords = function() {
        var selected = $('tbody > tr > td:nth-child(1) input[type="checkbox"]', table).size();
    };

    return {
        init: function(options) {

            if (!$().dataTable) {
                return;
            }

            the = this;

            options = $.extend(true, {
                src: "",
                wapContent: ".table-datatable",
                wapHeight: "406px",
                dataTable: {
                    "serverSide": true,
                    "ordering": false,
                    "scrollX": true,
                    "ajax": {
                        "url": "",
                        "type": "POST",
                        "timeout": 20000,
                        "data": function(data) {
                            $.each(ajaxParams, function(key, value) {
                                data[key] = value;
                            });
                            Kiosk.blockTableUI(options.wapContent, options.wapHeight);
                        },
                        "dataSrc": function(res) {
                            if ($('.chk-all', tableWrapper).size() === 1) {
                                $('.chk-all', tableWrapper).prop("checked", false);
                                $.uniform.update($('.chk-all', tableWrapper));
                            }

                            if (tableOptions.onSuccess) {
                                tableOptions.onSuccess.call(undefined, the);
                            }

                            Kiosk.unblockTableUI('.table-datatable');

                            return res.data;
                        },
                        "error": function() {
                            if (tableOptions.onError) {
                                tableOptions.onError.call(undefined, the);
                            }

                            Kiosk.unblockTableUI('.table-datatable');
                        }
                    },
                    "rowCallback": function( row, data ) {
                        if($('.chk-all', tableWrapper)){
                            if($('.chk-all', tableWrapper).is(":checked")){
                                var id = data.DT_RowId;
                                if( $.inArray(id, nonsltCheckbox) === -1){
                                    if( $.inArray(id, sltCheckbox) === -1 ){
                                        sltCheckbox.push(id);
                                    }
                                    $(row).find('.item-select').prop('checked', true);
                                    Kiosk.updateUniform('.item-select', table);
                                }
                            }else{
                                var id = data.DT_RowId;
                                if ( $.inArray(id, sltCheckbox) !== -1 ) {
                                    $(row).find('.item-select').prop('checked', true);
                                    Kiosk.updateUniform('.item-select', table);
                                }
                            }
                        }
                        if($('#lb_sl').length > 0)
                            $('#lb_sl').text(sltCheckbox.length);
                    },
                    "drawCallback": function(oSettings) {

                        Kiosk.initUniform($('input[type="checkbox"]', table));

                        if (tableOptions.onDataLoad) {
                            tableOptions.onDataLoad.call(undefined, the);
                        }

                    }
                }
            }, options);

            tableOptions = options;

            table = $(options.src);

            tableContainer = table.parents(".table-container");

            // initialize a datatable
            dataTable = table.DataTable(options.dataTable);

            // get table wrapper
            tableWrapper = table.parents('.dataTables_wrapper');

            tableWrapper.on('click', '.chk-all', function(e){
                var c = this.checked;
                var sl = 0;
                $('.item-select:checkbox', table).prop('checked',c);
                sltCheckbox    = [];
                nonsltCheckbox = [];
                $('.item-select:checkbox', table).each(function() {
                    if($(this).is(':checked')){
                        var id    = $(this).val()
                        var index = $.inArray(id, sltCheckbox);
                        if ( index === -1 ) {
                            sltCheckbox.push( id );
                        }
                    }
                });
                Kiosk.updateUniform('.item-select', table);
                if($('#lb_sl').length > 0)
                    $('#lb_sl').text(sltCheckbox.length);
            });

            table.on('click', '.item-select', function(e){
                var id       = $(this).val();
                var index    = $.inArray(id, sltCheckbox);
                
                if ( index === -1 ) {
                    sltCheckbox.push(id);
                } else {
                    sltCheckbox.splice(index, 1);
                }

                if($('.chk-all', tableWrapper).is(":checked")){
                    var nonindex = $.inArray(id, nonsltCheckbox);
                    if ( nonindex === -1 ) {
                        nonsltCheckbox.push(id);
                    } else {
                        nonsltCheckbox.splice(nonindex, 1);
                    }
                }
                Kiosk.updateUniform('.item-select', table);
                if($('#lb_sl').length > 0)
                    $('#lb_sl').text(sltCheckbox.length);
            });

            // handle filter submit button click
            table.on('click', '.filter-submit', function(e) {
                e.preventDefault();
                the.submitFilter();
            });

            // handle filter cancel button click
            table.on('click', '.filter-cancel', function(e) {
                e.preventDefault();
                the.resetFilter();
            });
        },

        submitFilter: function() {
            the.setAjaxParam("action", tableOptions.filterApplyAction);

            // get all typeable inputs
            $('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function() {
                the.setAjaxParam($(this).attr("name"), $(this).val());
            });

            // get all checkboxes
            $('input.form-filter[type="checkbox"]:checked', table).each(function() {
                the.addAjaxParam($(this).attr("name"), $(this).val());
            });

            // get all radio buttons
            $('input.form-filter[type="radio"]:checked', table).each(function() {
                the.setAjaxParam($(this).attr("name"), $(this).val());
            });

            dataTable.ajax.reload();
        },

        resetFilter: function() {
            $('textarea.form-filter, select.form-filter, input.form-filter', table).each(function() {
                $(this).val("");
            });
            $('input.form-filter[type="checkbox"]', table).each(function() {
                $(this).attr("checked", false);
            });
            the.clearAjaxParams();
            the.addAjaxParam("action", tableOptions.filterCancelAction);
            dataTable.ajax.reload();
        },

        getSelectedID: function() {
            return sltCheckbox;
        },

        clearSelectedID: function() {
            sltCheckbox    = [];
            nonsltCheckbox = [];
        },

        getSelectedRowsCount: function() {
            return $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', table).size();
        },

        getSelectedRows: function() {
            var rows = [];
            $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', table).each(function() {
                rows.push($(this).val());
            });

            return rows;
        },

        setAjaxParam: function(name, value) {
            ajaxParams[name] = value;
        },

        addAjaxParam: function(name, value) {
            if (!ajaxParams[name]) {
                ajaxParams[name] = [];
            }

            skip = false;
            for (var i = 0; i < (ajaxParams[name]).length; i++) {
                if (ajaxParams[name][i] === value) {
                    skip = true;
                }
            }

            if (skip === false) {
                ajaxParams[name].push(value);
            }
        },

        clearAjaxParams: function(name, value) {
            ajaxParams = {};
        },

        getDataTable: function() {
            return dataTable;
        },

        getTableWrapper: function() {
            return tableWrapper;
        },

        gettableContainer: function() {
            return tableContainer;
        },

        getTable: function() {
            return table;
        }

    };

};