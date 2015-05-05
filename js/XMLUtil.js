var xmlReq = null;

//XMLHTTP for IE or Mozilla
function getXmlHTTP() {
    var xhr;

    xhr = null;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        try {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                xhr = null;
            }
        }
    }
    return xhr;
}

//inizializza per AJAX Nativo
function InitXMLHTTP() {
    xmlReq = getXmlHTTP();
}


//Cancella ogni tipo di ulteriore richiesta
function CancelCurrentRequest() {
    if (xmlReq != null)
        xmlReq.abort();
}


var _updatedRecordChange = false;
function UpdateGridRecordChange() {
    if (_updatedRecordChange) return;
    _updatedRecordChange = true;
    igtbl_Grid.prototype._recordChangeEX = igtbl_Grid.prototype._recordChange;
    igtbl_Grid.prototype._recordChange = function(type, obj, value) {
        if (type != "ChangedCells" && type != "AddedRows" && type != "DeletedRows") {
            this._recordChangeEX(type, obj, value);
        }
    }
}

function querySt(ji) {
    hu = window.location.search.substring(1);
    gy = hu.split("&");
    for (i = 0; i < gy.length; i++) {
        ft = gy[i].split("=");
        if (ft[0] == ji) {
            return ft[1];
        }
    }
}