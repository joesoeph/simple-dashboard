const app = {
    init: function () {
        $(function () {
            const $body = $("body");
            const $root = $("html");
            const $navbar = $(".main-header.navbar");
            const $buttons = $(".theme-btn");

            // Apply theme + set active button + update navbar
            function applyTheme(theme) {
                let isDark = false;

                // Determine if dark mode should be applied
                if (theme === "dark") {
                    isDark = true;
                } else if (theme === "light") {
                    isDark = false;
                } else {
                    // system
                    isDark = window.matchMedia(
                        "(prefers-color-scheme: dark)"
                    ).matches;
                }

                // Update body and html classes
                $body.toggleClass("dark-mode", isDark);
                $root.toggleClass("dark", isDark);

                // Update navbar classes
                if (isDark) {
                    $navbar
                        .removeClass("navbar-white navbar-light")
                        .addClass("bg-dark navbar-dark");
                } else {
                    $navbar
                        .removeClass("bg-dark navbar-dark")
                        .addClass("navbar-white navbar-light");
                }

                // Set active button
                $buttons.removeClass("active");
                $buttons.find('input[type="radio"]').prop("checked", false);

                const $activeBtn = $(`.theme-btn[data-theme="${theme}"]`);
                $activeBtn.addClass("active");
                $activeBtn.find('input[type="radio"]').prop("checked", true);

                // Save to localStorage
                localStorage.setItem("theme", theme);
            }

            // Load saved theme immediately on page load
            const savedTheme = localStorage.getItem("theme") || "system";
            applyTheme(savedTheme);

            // Click handler
            $buttons.on("click", function (e) {
                e.preventDefault();
                const theme = $(this).data("theme");
                applyTheme(theme);
            });

            // System change listener
            window
                .matchMedia("(prefers-color-scheme: dark)")
                .addEventListener("change", function () {
                    if (localStorage.getItem("theme") === "system") {
                        applyTheme("system");
                    }
                });

            // Initial on modal
            $(".modal").on("shown.bs.modal", function () {
                $(".select2bs4").select2({
                    placeholder: "",
                    theme: "bootstrap4",
                    dropdownParent: $(".modal"),
                    allowClear: true,
                });
            });

            // Initial on all pages
            $(".select2bs4").select2({
                placeholder: "",
                theme: "bootstrap4",
                allowClear: true,
            });
        });
    },
    helper: {
        openModal: (title, url) => {
            $("#globalModalTitle").text(title);
            $("#globalModalBody").html(
                '<div class="text-center p-3">Loading...</div>'
            );
            $("#globalModal").modal("show");

            axios
                .get(url)
                .then((res) => {
                    $("#globalModalBody").html(res.data);
                })
                .catch(() => {
                    $("#globalModalBody").html(
                        '<div class="alert alert-danger">Failed fetch data</div>'
                    );
                });
        },
        submitForm: (form, idTable) => {
            const url = form.action;
            const data = new FormData(form);
            const overlay = `<div class="form-overlay d-flex align-items-center justify-content-center" style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.6);z-index:10;">
                    <div class="spinner-border text-primary" role="status"></div>
                    </div>`;

            $(form).css("position", "relative").append(overlay);

            axios
                .post(url, data)
                .then((res) => {
                    $("#globalModal").modal("hide");
                    toastr.success(res.data.message || "Saved successfully");
                    $(idTable).DataTable().ajax.reload(null, false);
                })
                .catch((err) => {
                    if (err.response?.data?.errors) {
                        const errorList = Object.values(
                            err.response.data.errors
                        )
                            .flat()
                            .map((msg) => `<li>${msg}</li>`)
                            .join("");

                        $("#formErrors").html(`
                        <div class="alert alert-danger mb-3" role="alert">
                            <div class="fw-bold mb-1">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                Please fix the following errors:
                            </div>
                            <ul class="mb-0 ps-3">${errorList}</ul>
                        </div>
                    `);
                    } else {
                        toastr.error("An error occurred!");
                    }
                })
                .finally(() => {
                    $(form).find(".form-overlay").remove();
                });
            return false;
        },
        confirmDelete: (url, options = {}) => {
            console.log({ options });
            const {
                onSuccess = null, // callback when delete is successful
                onError = null, // callback when delete fails
                reloadTable = null, // e.g. '#myTable'
                messages = {}, // custom messages
            } = options;

            const config = {
                title: messages.title || "Are you sure?",
                text: messages.text || "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: messages.confirmText || "Yes, delete it!",
                cancelButtonText: messages.cancelText || "Cancel",
                successMessage:
                    messages.successMessage || "The item has been deleted.",
                errorMessage:
                    messages.errorMessage ||
                    "An error occurred while deleting the item.",
            };

            Swal.fire(config).then((result) => {
                if (!result.isConfirmed) return;

                axios
                    .delete(url)
                    .then((res) => {
                        Swal.fire(
                            "Deleted!",
                            res.data.message || config.successMessage,
                            "success"
                        );

                        if (reloadTable) {
                            $(reloadTable).DataTable().ajax.reload(null, false);
                        }

                        console.log(onSuccess);

                        if (typeof onSuccess === "function") {
                            onSuccess(res);
                        }
                    })
                    .catch((err) => {
                        Swal.fire("Failed", config.errorMessage, "error");

                        if (typeof onError === "function") {
                            onError(err);
                        }
                    });
            });
        },
    },
};
app.init();
