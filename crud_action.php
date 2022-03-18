<?php
include 'function.php';

$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
?>

<?=template_header('Contacts')?>
    <div class="py-6 md:py-12">
        <button type="button" class="inline-block px-6 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out ml-10"
            data-bs-toggle="modal" data-bs-target="#contactModal" name="create" id="create">
            create contacts
        </button>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full" id="contacts_table">
                            <thead class="border-b">
                                <tr>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        #
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Name
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Email
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Phone
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Title
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Create
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                <tr class="border-b">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?=$contact['id']?></td>
                                    <td class="text-sm text-gray-900 font-mono px-6 py-4 whitespace-nowrap"><?=$contact['name']?></td>
                                    <td class="text-sm text-gray-900 font-mono px-6 py-4 whitespace-nowrap"><?=$contact['email']?></td>
                                    <td class="text-sm text-gray-900 font-mono px-6 py-4 whitespace-nowrap"><?=$contact['phone']?></td>
                                    <td class="text-sm text-gray-900 font-mono px-6 py-4 whitespace-nowrap"><?=$contact['title']?></td>
                                    <td class="text-sm text-gray-900 font-mono px-6 py-4 whitespace-nowrap"><?=$contact['created']?></td>
                                     <td class="text-sm text-gray-900 font-mono px-6 py-4 whitespace-nowrap">
                                        <a id="<?php echo $contact['id']?>" class="px-6 py-2.5 bg-blue-400 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-500 hover:shadow-lg focus:bg-blue-500 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-600 active:shadow-lg transition duration-150 ease-in-out edit_data" data-bs-toggle="modal" data-bs-target="#contactModal"><i class="fas fa-pen fa-xs"></i><a>
                                        <a id="<?php echo $contact['id']?>" class="px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out delete_data" ><i class="fas fa-trash fa-xs"></i><a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        <table>

                            <div class="flex justify-center">
                                <nav aria-label="Page navigation example">
                                    <ul class="flex list-style-none">
                                    <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a href="crud_action.php?page=<?=$page-1?>" class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none">Previous</a></li>
                                    <?php endif; ?>
                                    <?php if ($page*$records_per_page < $num_contacts): ?>

                                    <li class="page-item"><a
                                        class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
                                        href="crud_action.php?page=<?=$page+1?>">Next</a></li>
                                    <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                    </div>
            </div>
        </div>

    </div>
<?=template_footer()?>

<!-- Modal create contacts -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto "
    id="contactModal" tabindex="-1" aria-labelledby="exampleModalScrollableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable relative w-auto pointer-events-none">
        <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                <h5 class="text-xl font-medium leading-normal text-gray-800 modal-title" id="exampleModalScrollableLabel">
                    Create Contact
                </h5>
                    <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="contact_form"> 
                <div class="modal-body relative p-4">
                    <div class="mb-6">
                        <input type="email" class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" 
                            id="email" name="email" placeholder="Email address" />
                    </div>
                </div>
                <div class="modal-body relative p-4">
                    <div class="mb-6">
                        <input type="text" class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" 
                            id="name" name="name" placeholder="Name" />
                    </div>
                </div>
                <div class="modal-body relative p-4">
                    <div class="mb-6">
                        <input type="text" class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" 
                            id="title" name="title" placeholder="Title" />
                    </div>
                </div>
                <div class="modal-body relative p-4">
                    <div class="mb-6">
                        <input type="phone" class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" 
                            id="phone" name="phone" placeholder="Phone" />
                    </div>
                </div>
                <div class="modal-body relative p-4">
                    <div class="mb-6">
                        <input type="datetime-local" class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" 
                            value="<?=date('Y-m-d\TH:i')?>" id="created" name="created" placeholder="Create at" />
                    </div>
                </div>
                <input type="hidden" name="contacts_id" id="contacts_id" />
                <input type="hidden" name="operation" id="operation" />
                <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <button type="button" class="inline-block px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
                        data-bs-dismiss="modal"> 
                        Close 
                    </button>
                    <input type="submit" name="action" id="action" value="Create" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">
                    </input>
                </div>
            </form>
        </div>
    </div>
</div>
