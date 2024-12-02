$(document).ready(function () {
  // Load data from localStorage when the page loads
  const loadAlumniData = () => {
    const alumniData = JSON.parse(localStorage.getItem("alumniData")) || [];
    alumniData.forEach((alumni) => {
      addAlumniToTable(alumni);
    });
  };

  const saveAlumniData = (data) => {
    localStorage.setItem("alumniData", JSON.stringify(data));
  };

  const getAlumniData = () => {
    return JSON.parse(localStorage.getItem("alumniData")) || [];
  };

  const addAlumniToTable = (alumni) => {
    const newRow = `
      <tr>
        <td class="name">${alumni.name}</td> 
        <td class="year">${alumni.year}</td>
        <td><img src="${alumni.photo}" alt="Photo ${alumni.name}" class="alumni-photo"></td>
        <td class="action-buttons">
          <button class="delete">Hapus</button>
        </td>
      </tr>`;
    $("#alumniTable tbody").append(newRow);
  };

  // Load saved alumni data
  loadAlumniData();

  // Event Form: Submit
  $("#alumniForm").submit(function (event) {
    event.preventDefault(); // Prevent form submission

    const name = $("#name").val();
    const year = $("#year").val();
    const photo = $("#photo")[0].files[0];

    if (name && year && photo) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const alumni = {
          name: name,
          year: year,
          photo: e.target.result,
        };

        // Add to table
        addAlumniToTable(alumni);

        // Save to localStorage
        const alumniData = getAlumniData();
        alumniData.push(alumni);
        saveAlumniData(alumniData);

        // Clear form
        $("#name").val("");
        $("#year").val("");
        $("#photo").val("");

        alert("Data alumni ditambahkan!\nNama: " + name + "\nTahun: " + year);
      };
      reader.readAsDataURL(photo);
    } else {
      alert("Harap isi semua kolom!");
    }
  });

  // Hapus Alumni
  $("#alumniTable").on("click", ".delete", function () {
    const row = $(this).closest("tr");
    const name = row.find(".name").text();

    // Remove from localStorage
    let alumniData = getAlumniData();
    alumniData = alumniData.filter((alumni) => alumni.name !== name);
    saveAlumniData(alumniData);

    // Remove row from table
    row.remove();
  });

  // Fitur Pencarian
  $("#searchAlumni").on("input", function () {
    const query = $(this).val().toLowerCase();
    $("#alumniTable tbody tr").each(function () {
      const name = $(this).find(".name").text().toLowerCase();
      const year = $(this).find(".year").text().toLowerCase();

      if (name.includes(query) || year.includes(query)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  // Event Dokumen/Window: Resize
  $(window)
    .on("resize", function () {
      const width = $(window).width();
      const height = $(window).height();
      $("#windowSize").text("Ukuran jendela: " + width + " x " + height);
    })
    .trigger("resize"); // Menampilkan ukuran saat halaman pertama kali dimuat

  // Animasi dan Interaksi dengan Gambar
  $("#alumniTable")
    .on("mouseenter", "img", function () {
      $(this).css({
        transform: "scale(1.1)",
        filter: "brightness(1.2)",
      });
    })
    .on("mouseleave", "img", function () {
      $(this).css({
        transform: "scale(1)",
        filter: "brightness(1)",
      });
    })
    .on("mousedown", "img", function () {
      $(this).css({
        transform: "scale(0.95)",
        filter: "brightness(0.8)",
      });
    })
    .on("mouseup", "img", function () {
      $(this).css({
        transform: "scale(1)",
        filter: "brightness(1)",
      });
      $("#output").text("Mouse button dilepaskan pada gambar.");
    })
    .on("dblclick", "img", function () {
      $(this).css({
        transform: "rotate(15deg)",
        filter: "brightness(1.2)",
      });
      setTimeout(() => {
        $(this).css({
          transform: "rotate(0deg)",
          filter: "brightness(1)",
        });
      }, 500);
    })
    .on("selectstart", "img", function () {
      $("#output").text("Gambar sedang dipilih...");
    })
    .on("mousemove", "img", function (event) {
      const offsetX = event.offsetX;
      const offsetY = event.offsetY;
      $("#output").text("Gerakkan mouse: X=" + offsetX + ", Y=" + offsetY);
    });
});
