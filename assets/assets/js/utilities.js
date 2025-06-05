class Loading {
    starLoading() {
        $("#loading").show();
    };
    endLoading() {
        $("#loading").fadeOut(1000, function() {
            $("#loading").hide();
        });
    };
}

export default new Loading;