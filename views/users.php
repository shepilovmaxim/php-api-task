<?php if(Auth::loggedIn()): ?>
<div class="container mt-3">
    <div class="alert alert-primary text-center">Your API-key: <?= $_SESSION['key'] ?> <br/> Use the following link to get users: <?= 'https://' . $_SERVER['SERVER_NAME'] . '/api?apikey=' . $_SESSION['key'] ?> <br/> You also can specify type of response by adding a "type" parameter with value "json" or "xml". <br/> For example: <?= 'https://' . $_SERVER['SERVER_NAME'] . '/api?apikey=' . $_SESSION['key'] . "&type=json" ?> </div>
    <div class="d-flex justify-content-center">
        <table class="table" id="users_table">
            <thead>
                <tr align="center">
                    <th scope="col" id="name_sort" style="cursor: pointer; color: CornflowerBlue;">Name</th>
                    <th scope="col" id="email_sort" style="cursor: pointer; color: CornflowerBlue;">Email</th>
                    <th scope="col">Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $user): ?>
                    <tr align="center">
                        <td class="align-middle"><?= $user['name']; ?></td>
                        <td class="align-middle"><?= $user['email']; ?></td>
                        <td class="align-middle"><img src="/images/<?= $user['photo']; ?>" width="200" height ="130"></td>     
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>

        const table = document.getElementById("users_table");
        const nameSort = document.getElementById("name_sort");
        const emailSort = document.getElementById("email_sort");

        nameSort.addEventListener("click", (event) => {
            let sortedRows = Array.from(table.rows)
                            .slice(1)
                            .sort((rowA, rowB) => { 
                                if (rowA.cells[0].textContent.toLowerCase() > rowB.cells[0].textContent.toLowerCase()) {
                                    return 1;
                                } else if (rowA.cells[0].textContent.toLowerCase() == rowB.cells[0].textContent.toLowerCase()) {
                                    return 0;
                                } else if (rowA.cells[0].textContent.toLowerCase() < rowB.cells[0].textContent.toLowerCase()) {
                                    return -1;
                                }
                            });
            table.tBodies[0].append(...sortedRows);
        });

        emailSort.addEventListener("click", (event) => {
            let sortedRows = Array.from(table.rows)
                            .slice(1)
                            .sort((rowA, rowB) => { 
                                if (rowA.cells[1].textContent.toLowerCase() > rowB.cells[1].textContent.toLowerCase()) {
                                    return 1;
                                } else if (rowA.cells[1].textContent.toLowerCase() == rowB.cells[1].textContent.toLowerCase()) {
                                    return 0;
                                } else if (rowA.cells[1].textContent.toLowerCase() < rowB.cells[1].textContent.toLowerCase()) {
                                    return -1;
                                }
                            });
            table.tBodies[0].append(...sortedRows);
        });

    </script>
</div>
<?php else: ?>
    <div class='container mt-3'><div class='alert alert-danger text-center'>Login to access the table</div></div>
<?php endif; ?>