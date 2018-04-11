(function() {
    var z = $('nav').height();
    $('body').css( "padding-top", z+'px');
    iosLinks();
})();

function iosLinks() {
    if(("standalone" in window.navigator) && window.navigator.standalone) {
        $('a').click(function(event) {
            event.preventDefault();
            if( location.hostname === this.hostname || !this.hostname.length ) {
                window.location = $(this).attr("href");
            } else {
                window.open( this.href, '_blank');
            }
        });
    }
}

function clickAndDisable(link) {
    $(link).addClass('disabled');
    $(link).find('span').html('procesando...');
}

function remove_accent(str) {
    var map={'À':'A','Á':'A','Â':'A','Ã':'A','Ä':'A','Å':'A','Æ':'AE','Ç':'C','È':'E','É':'E','Ê':'E','Ë':'E','Ì':'I','Í':'I','Î':'I','Ï':'I','Ð':'D','Ñ':'N','Ò':'O','Ó':'O','Ô':'O','Õ':'O','Ö':'O','Ø':'O','Ù':'U','Ú':'U','Û':'U','Ü':'U','Ý':'Y','ß':'s','à':'a','á':'a','â':'a','ã':'a','ä':'a','å':'a','æ':'ae','ç':'c','è':'e','é':'e','ê':'e','ë':'e','ì':'i','í':'i','î':'i','ï':'i','ñ':'n','ò':'o','ó':'o','ô':'o','õ':'o','ö':'o','ø':'o','ù':'u','ú':'u','û':'u','ü':'u','ý':'y','ÿ':'y','Ā':'A','ā':'a','Ă':'A','ă':'a','Ą':'A','ą':'a','Ć':'C','ć':'c','Ĉ':'C','ĉ':'c','Ċ':'C','ċ':'c','Č':'C','č':'c','Ď':'D','ď':'d','Đ':'D','đ':'d','Ē':'E','ē':'e','Ĕ':'E','ĕ':'e','Ė':'E','ė':'e','Ę':'E','ę':'e','Ě':'E','ě':'e','Ĝ':'G','ĝ':'g','Ğ':'G','ğ':'g','Ġ':'G','ġ':'g','Ģ':'G','ģ':'g','Ĥ':'H','ĥ':'h','Ħ':'H','ħ':'h','Ĩ':'I','ĩ':'i','Ī':'I','ī':'i','Ĭ':'I','ĭ':'i','Į':'I','į':'i','İ':'I','ı':'i','Ĳ':'IJ','ĳ':'ij','Ĵ':'J','ĵ':'j','Ķ':'K','ķ':'k','Ĺ':'L','ĺ':'l','Ļ':'L','ļ':'l','Ľ':'L','ľ':'l','Ŀ':'L','ŀ':'l','Ł':'L','ł':'l','Ń':'N','ń':'n','Ņ':'N','ņ':'n','Ň':'N','ň':'n','ŉ':'n','Ō':'O','ō':'o','Ŏ':'O','ŏ':'o','Ő':'O','ő':'o','Œ':'OE','œ':'oe','Ŕ':'R','ŕ':'r','Ŗ':'R','ŗ':'r','Ř':'R','ř':'r','Ś':'S','ś':'s','Ŝ':'S','ŝ':'s','Ş':'S','ş':'s','Š':'S','š':'s','Ţ':'T','ţ':'t','Ť':'T','ť':'t','Ŧ':'T','ŧ':'t','Ũ':'U','ũ':'u','Ū':'U','ū':'u','Ŭ':'U','ŭ':'u','Ů':'U','ů':'u','Ű':'U','ű':'u','Ų':'U','ų':'u','Ŵ':'W','ŵ':'w','Ŷ':'Y','ŷ':'y','Ÿ':'Y','Ź':'Z','ź':'z','Ż':'Z','ż':'z','Ž':'Z','ž':'z','ſ':'s','ƒ':'f','Ơ':'O','ơ':'o','Ư':'U','ư':'u','Ǎ':'A','ǎ':'a','Ǐ':'I','ǐ':'i','Ǒ':'O','ǒ':'o','Ǔ':'U','ǔ':'u','Ǖ':'U','ǖ':'u','Ǘ':'U','ǘ':'u','Ǚ':'U','ǚ':'u','Ǜ':'U','ǜ':'u','Ǻ':'A','ǻ':'a','Ǽ':'AE','ǽ':'ae','Ǿ':'O','ǿ':'o'};
    var res='';
    for (var i=0;i<str.length;i++){
        c=str.charAt(i);
        res+=map[c]||c;
    }
    return res;
}

let notify = (function() {
    let success = function(params) {
        params.tipo = 'success';
        return addNotify(params);
    };
    let info = function(params) {
        params.tipo = 'info';
        return addNotify(params);
    };
    let danger = function(params) {
        params.tipo = 'danger';
        return addNotify(params);
    };
    let warning = function(params) {
        params.tipo = 'warning';
        return addNotify(params);
    };


    let addNotify = function(params) {
        let item = document.createElement('div');
        item.className = 'notify';
        item.classList.add(params.tipo);
        item.setAttribute('role','alert');

        let msj = document.createElement('p');
        msj.innerText = params.msj;
        item.appendChild(msj);

        if ( params.list ) {
            let ul = document.createElement('ul');
            params.list.forEach(function (e) {
                let li = document.createElement('li');
                li.innerText = e;
                ul.appendChild(li);
            });
            item.appendChild(ul);
        }
        
        if ( params.button ) {
            let btn = document.createElement('a');
            btn.innerText = params.button;
            btn.className = 'notify-link';
            btn.setAttribute('href',params.link);
            btn.setAttribute('role','button');
            btn.setAttribute('aria-label','click aqui para '+params.button);
            item.appendChild(btn);
        }

        let close = document.createElement('button');
        close.innerHTML = '&times;';
        close.className = 'close-notify';
        close.setAttribute('title','cerrar');
        close.setAttribute('aria-label','cerrar notificacion');
        close.addEventListener("click", function(){
            item.style.opacity = '0';
            setTimeout(function(){ close.parentNode.parentNode.removeChild(close.parentNode); }, 100);
        });
        item.appendChild(close);
        
        closeAll();
        document.getElementById('notify-container').appendChild(item);
        setTimeout(function(){item.style.opacity = '1';}, 100);
    }
    let closeAll = function () {
        let closing = document.getElementById('notify-container');
        while (closing.firstChild) {
            closing.removeChild(closing.firstChild);
        }
    }
    return {
    success: success,
    info: info,
    danger: danger,
    warning: warning,
    closeAll: closeAll
    };
    
})();

let audioAlert = (function () {
    let init = function () {
        soundFile = new Audio ();
        soundFile.volume = 1;
        soundFile.src = '/sound/null.mp3';
        soundFile.play();
    }
    let error = function () {
        let path = '/sound/error.mp3';
        return playAlert(path);
    }
    let success = function () {
        let path = '/sound/success.mp3';
        return playAlert(path);
    }
    let info = function () {
        let path = '/sound/info.mp3';
        return playAlert(path);
    }
    let click = function () {
        if (typeof soundFile === 'undefined') {
            soundFile = new Audio ();
            soundFile.volume = 1;
        }
        path = '/sound/click.mp3';
        return playAlert(path);
    }

    let playAlert = function (path) {
        soundFile.pause();
        soundFile.src = path;
        soundFile.load();
        soundFile.play();
      }
    return {
        init:init,
        error:error,
        success:success,
        info:info,
        click:click
    };    
})();

let encargoAction = (function() {
    let concluir = function(params) {
        params.notificacion = notify.success;
        params.alerta = audioAlert.success;
        return ejecutar(params);
    };
    let rechazar = function(params) {
        params.notificacion =  notify.info;
        params.alerta = audioAlert.info;
        return ejecutar(params);
    };

    let ejecutar = function(params) {
        var bool = false;
        $.ajax({
            type: "GET",
            url: $(params.btn).data('url'),
            async: false,
            beforeSend: function () {
                $(params.btn).prop( "disabled", true );
            },
            success: function(data){
                params.notificacion({msj:data.message});
                params.alerta();
                if (params.final) { params.final(data); }
                bool= true;
             },
            error: function(error){
                notify.danger({msj:error.responseJSON.message});
                audioAlert.error();
            }
        });
        return bool;
    }
    return {
        concluir:concluir,
        rechazar:rechazar
    }
})();