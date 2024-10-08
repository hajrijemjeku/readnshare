<?php include('includes/header.php'); 
$errors = [];
?>

<script src="./node_modules/axios/dist/axios.js"></script>

<section class="signup-section py-5">
    <div class="container">
        <div class="row mt-4" id="showapi"></div>
    </div>

    <script>
    let api = 'https://freetestapi.com/api/v1/books';
    let divcontainer = document.getElementById('showapi');

    axios.get(api)
    .then(resolve => {
        let data = resolve.data;
        console.log(data);

        divcontainer.innerHTML = '';

        let searchValue = new URLSearchParams(window.location.search).get('search-value');
        searchValue = searchValue ? searchValue.trim().toLowerCase() : '';

        data.forEach(test => {
            if (!searchValue || (test.title.toLowerCase().includes(searchValue) || test.author.toLowerCase().includes(searchValue))) {
                divcontainer.innerHTML += `
                <div class="col-md-6 col-lg-12 mb-4">
                    <div class="list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <a style="width:200px;">
                                <img src="${test.cover_image}" class="card-img-top p-3" style="height:250px" alt="${test.title}">
                            </a>
                            <div class="book-details text-center" style="flex-grow: 1;">
                                <a style="text-decoration: none; color: inherit;">
                                    <h5 class="mb-1">Title: <strong>${test.title}</strong></h5>
                                    <p class="mb-1">Author: <strong>${test.author}</strong></p>
                                    <p class="mb-1">Description: <strong>${test.description}</strong></p>
                                    <p class="mb-1">Publication Year: <strong>${test.publication_year}</strong></p>
                                    <p class="mb-1">Genre: <strong>${test.genre}</strong></p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            }
        });

        if (divcontainer.innerHTML === '') {
            divcontainer.innerHTML = "<h2 class='text-center mb-5' style='color:darkolivegreen;'>No results found. Please try a different title or author.</h2>";
        }

    }).catch(reject => console.log(reject));
    </script>
</section>

<?php include('includes/footer.php'); ?>
