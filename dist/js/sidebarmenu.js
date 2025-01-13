/*
Template Name: Admin Template
Author: Wrappixel

File: js
*/

// ==============================================================
// Auto select left navbar
// ==============================================================
$(function () {
  "use strict";

  // Get the current URL and extract the path
  var url = window.location + "";
  var path = url.replace(
    window.location.protocol + "//" + window.location.host + "/",
    ""
  );

  // Highlight the matching sidebar item
  var element = $("ul#sidebarnav a").filter(function () {
    return this.href === url || this.href === path;
  });
  element.parentsUntil(".sidebar-nav").each(function () {
    if ($(this).is("li") && $(this).children("a").length !== 0) {
      $(this).children("a").addClass("active");
      $(this).parent("ul#sidebarnav").length === 0
        ? $(this).addClass("active")
        : $(this).addClass("selected");
    } else if (!$(this).is("ul") && $(this).children("a").length === 0) {
      $(this).addClass("selected");
    } else if ($(this).is("ul")) {
      $(this).addClass("in");
    }
  });

  element.addClass("active");

  // Toggle submenus on click
  $("#sidebarnav a").on("click", function (e) {
    if (!$(this).hasClass("active")) {
      $("ul", $(this).parents("ul:first")).removeClass("in");
      $("a", $(this).parents("ul:first")).removeClass("active");
      $(this).next("ul").addClass("in");
      $(this).addClass("active");
    } else if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(this).parents("ul:first").removeClass("active");
      $(this).next("ul").removeClass("in");
    }
  });

  // Prevent default behavior for links with submenus
  $("#sidebarnav >li >a.has-arrow").on("click", function (e) {
    e.preventDefault();
  });
});

// ==============================================================
// Dynamic Content Loading
// ==============================================================

function loadContent(page, postData = null) {
  const contentDiv = document.getElementById("page-wrapper");

  fetch(page, {
    method: postData ? "POST" : "GET",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: postData ? new URLSearchParams(postData).toString() : null,
  })
    .then((response) => {
      console.log(response); // Debug response
      if (!response.ok) {
        throw new Error(`Could not load ${page}: ${response.statusText}`);
      }
      return response.text();
    })
    .then((html) => {
      console.log(html); // Debug content
      contentDiv.innerHTML = html;

      // Reinitialize DataTable after loading content
      const table = document.querySelector("#zero_config");
      if (table) {
        if (typeof $.fn.DataTable === "function") {
          // Destroy any existing DataTable instance if it exists
          if ($.fn.DataTable.isDataTable(table)) {
            $(table).DataTable().destroy();
          }

          // Bind tab change event to reinitialize DataTable when needed
          $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (event) {
            var tabID = $(event.target).attr('href').substring(1); // Get the ID of the shown tab
            if ($('#' + tabID).find('#zero_config').length) {
              //newTable.columns.adjust().responsive.recalc();
			  // Initialize DataTable
			  $(table).DataTable();
            }
          });
		  
          // Initialize DataTable
          const newTable = $(table).DataTable({
            responsive: true, // Make the table responsive
          });
		  
        } else {
          console.error("DataTables is not loaded properly.");
        }
      }
    })
    .catch((error) => {
      console.error(error); // Debug error
      contentDiv.innerHTML = `<p>Error loading content: ${error.message}</p>`;
    });
}

/*function loadContent(page, postData = null) {
  const contentDiv = document.getElementById("page-wrapper");

  fetch(page, {
    method: postData ? "POST" : "GET",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: postData ? new URLSearchParams(postData).toString() : null,
  })
    .then((response) => {
      console.log(response); // Debug response
      if (!response.ok) {
        throw new Error(`Could not load ${page}: ${response.statusText}`);
      }
      return response.text();
    })
    .then((html) => {
      console.log(html); // Debug content
      contentDiv.innerHTML = html;

      // Reinitialize DataTable after loading content
      const table = document.querySelector("#zero_config");
      if (table) {
        if (typeof $.fn.DataTable === "function") {
          // Destroy any existing DataTable instance if it exists
          if ($.fn.DataTable.isDataTable(table)) {
            $(table).DataTable().destroy();
          }
          // Initialize DataTable
          $(table).DataTable();
        } else {
          console.error("DataTables is not loaded properly.");
        }
      }
    })
    .catch((error) => {
      console.error(error); // Debug error
      contentDiv.innerHTML = `<p>Error loading content: ${error.message}</p>`;
    });
}

function loadContent(page, postData = null) {
  const contentDiv = document.getElementById("page-wrapper");

  fetch(page, {
    method: postData ? "POST" : "GET",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: postData ? new URLSearchParams(postData).toString() : null,
  })
    .then((response) => {
      console.log(response); // Debug response
      if (!response.ok) {
        throw new Error(`Could not load ${page}: ${response.statusText}`);
      }
      return response.text();
    })
    .then((html) => {
      console.log(html); // Debug content
      contentDiv.innerHTML = html;
    })
    .catch((error) => {
      console.error(error); // Debug error
      contentDiv.innerHTML = `<p>Error loading content: ${error.message}</p>`;
    });
}

function loadContent(page) {
  const contentDiv = document.getElementById("page-wrapper");

  fetch(page)
    .then((response) => {
      console.log(response); // Debug response
      if (!response.ok) {
        throw new Error(`Could not load ${page}: ${response.statusText}`);
      }
      return response.text();
    })
    .then((html) => {
      console.log(html); // Debug content
      contentDiv.innerHTML = html;
    })
    .catch((error) => {
      console.error(error); // Debug error
      contentDiv.innerHTML = `<p>Error loading content: ${error.message}</p>`;
    });
}

function loadContent(page) {
  const contentDiv = document.getElementById("page-wrapper");

  // Extract the filter parameter if it exists
  const url = new URL(page, window.location.origin);
  const filter = url.searchParams.get("filter") || "all"; // Default to "all" if no filter provided

  fetch(page)
    .then((response) => {
      console.log(response); // Debug response
      if (!response.ok) {
        throw new Error(`Could not load ${page}: ${response.statusText}`);
      }
      return response.text();
    })
    .then((html) => {
      console.log(html); // Debug content
      contentDiv.innerHTML = html;

      // Optionally apply logic based on the filter
      if (filter) {
        console.log(`Content filtered by: ${filter}`);
        // Example: Use filter to toggle active tabs or perform additional actions
      }
    })
    .catch((error) => {
      console.error(error); // Debug error
      contentDiv.innerHTML = `<p>Error loading content: ${error.message}</p>`;
    });
}*/

// Load home.php by default on page load
document.addEventListener("DOMContentLoaded", () => {
  loadContent("home.php");
});
