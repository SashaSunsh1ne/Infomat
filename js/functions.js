function Exit() {
    $url = "../exit.php";
    OpenUrlThisTab($url);
}

function OpenUrlThisTab(url) {
    window.open(url, "_self");
}

function Home() {
    window.open("http://Infomat/", "_self");
}

function Reload() {
    window.location.reload();
}

function OpenUrlNewTab(url) {
    window.open(url, "_blank");
}

function Cut(barcode) {
    barcode.replace('-', '');
    return barcode;
}

function CallPrint(strid, count) {
    var prtContent = document.getElementById(strid);
    var prtCSS1 = '<link rel="stylesheet" href="../css/blocks.css" type="text/css" />'
    var prtCSS2 = '<link rel="stylesheet" href="../css/elements.css" type="text/css" />';
    var WinPrint = window.open('', '', 'left=50,top=50,width=auto,height=auto,toolbar=0,scrollbars=1,status=0');
    WinPrint.document.write(prtCSS1);
    WinPrint.document.write(prtCSS2);
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    var is_chrome = function() { return Boolean(WinPrint.chrome); }
    WinPrint.onload = function() {
        if (is_chrome) {
            WinPrint.moveTo(0, 0);
            WinPrint.resizeTo(640, 480);
            WinPrint.print();
            setTimeout(function() {
                WinPrint.close();
            }, 1);
        } else {
            WinPrint.print();
            WinPrint.close();
        }
    }
}