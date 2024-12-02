$(document).ready(function () {
    // Efek fade-in untuk semua gambar saat halaman dimuat
    $(".gallery img").each(function(index) {
        $(this).delay(index * 500).fadeTo(1000, 1); // Fade-in setiap gambar dengan delay
    });

    // Menampilkan gambar di dalam modal saat gambar diklik
    $(".gallery img").on("click", function () {
        var src = $(this).attr("src");
        $("#modalImage").attr("src", src);
        $("#myModal").fadeIn();
    });

    // Menutup modal saat tombol "Close" diklik
    $(".close").on("click", function () {
        $("#myModal").fadeOut();
    });

    // Menutup modal jika area di luar gambar diklik
    $(window).on("click", function (event) {
        if ($(event.target).is("#myModal")) {
            $("#myModal").fadeOut();
        }
    });
});

