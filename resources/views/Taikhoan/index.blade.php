@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .table-header-custom {
            background-color: #f3f4f6; /* Tailwind gray-100 */
            font-weight: 600; /* semibold */
        }
        .action-button {
            padding: 0.375rem 0.75rem; /* py-1.5 px-3 */
            border-radius: 0.375rem; /* rounded-md */
            font-size: 0.875rem; /* text-sm */
            margin-right: 0.5rem; /* mr-2 */
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem; /* gap-1 */
        }
        .add-button {
            background-color: #10b981; /* bg-emerald-500 */
            color: white;
        }
        .add-button:hover {
            background-color: #059669; /* bg-emerald-600 */
        }
        .edit-button {
            background-color: #3b82f6; /* bg-blue-500 */
            color: white;
        }
        .edit-button:hover {
            background-color: #2563eb; /* bg-blue-600 */
        }
        .delete-button {
            background-color: #ef4444; /* bg-red-500 */
            color: white;
        }
        .delete-button:hover {
            background-color: #dc2626; /* bg-red-600 */
        }
        .reset-password-button {
            background-color: #f59e0b; /* bg-amber-500 */
            color: white;
        }
        .reset-password-button:hover {
            background-color: #d97706; /* bg-amber-600 */
        }
        .search-bar input {
            border-radius: 0.375rem; /* rounded-md */
            border: 1px solid #d1d5db; /* border-gray-300 */
            padding: 0.5rem 0.75rem; /* py-2 px-3 */
        }
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 2rem; /* p-8 */
            border: 1px solid #888;
            width: 90%;
            max-width: 500px; /* md:max-w-md */
            border-radius: 0.5rem; /* rounded-lg */
            position: relative;
        }
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
        }
        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .form-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            margin-top: 0.25rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.25rem;
            font-weight: 500;
            color: #374151; /* text-gray-700 */
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .submit-button {
            background-color: #10b981;
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            font-weight: 500;
        }
        .submit-button:hover {
            background-color: #059669;
        }
    </style>
</head>
<body class="bg-gray-50 p-4 sm:p-6">
    <div class="container mx-auto max-w-7xl bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 text-center">Quản Lý Tài Khoản</h1>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <div class="search-bar w-full sm:w-auto">
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Tìm kiếm theo tài khoản, họ tên..." class="w-full sm:w-80 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button id="addAccountBtn" class="action-button add-button w-full sm:w-auto">
                <i class="fas fa-plus mr-2"></i>Thêm Tài Khoản
            </button>
        </div>

        <div class="overflow-x-auto">
            <table id="accountsTable" class="min-w-full divide-y divide-gray-200 border border-gray-300">
                <thead class="table-header-custom">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Tài Khoản</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Họ Tên</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Loại TK</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Số Điện Thoại</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Hành Động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="accountsTableBody">
                    </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px d-none" aria-label="Pagination">
                <a href="#" id="prevPage" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                  <i class="fas fa-chevron-left"></i>&nbsp;Trước
                </a>
                <span id="pageNumbers" class="relative inline-flex items-center">
                    </span>
                <a href="#" id="nextPage" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                  Sau&nbsp;<i class="fas fa-chevron-right"></i>
                </a>
            </nav>
        </div>
    </div>

    <div id="accountModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeModalBtn">&times;</span>
            <h2 id="modalTitle" class="text-xl font-semibold mb-4">Thêm Tài Khoản Mới</h2>
            <form id="accountForm">
                <input type="hidden" id="editModeTaikhoan" value=""> <div class="form-group">
                    <label for="taikhoan" class="form-label">Tài Khoản:</label>
                    <input type="text" id="taikhoan" name="taikhoan" class="form-input" required>
                </div>
                <div class="form-group" id="passwordGroup">
                    <label for="matkhau" class="form-label">Mật Khẩu:</label>
                    <input type="password" id="matkhau" name="matkhau" class="form-input">
                    <small id="passwordHelp" class="text-xs text-gray-500 mt-1">Để trống nếu không muốn thay đổi mật khẩu khi sửa.</small>
                </div>
                <div class="form-group">
                    <label for="info" class="form-label">Họ Tên (Info):</label>
                    <input type="text" id="info" name="info" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="loaitk" class="form-label">Loại Tài Khoản:</label>
                    <select id="loaitk" name="loaitk" class="form-input" required>
                        <option value="">Chọn loại tài khoản</option>
                        <option value="A">Quản trị viên</option>
                        <option value="M">Quản lý</option>
                        <option value="U">Người dùng</option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="sdt" class="form-label">Số Điện Thoại:</label>
                    <input type="tel" id="sdt" name="sdt" class="form-input">
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-input">
                </div>
                <button type="submit" class="submit-button">Lưu Tài Khoản</button>
            </form>
        </div>
    </div>

    <script>
        const mockAccounts = [
            { taikhoan: 'admin', matkhau: 'hashed_password_1', loaitk: 'A', sdt: '0328137723', email: 'trieug88@gmail.com', info: 'Nguyễn Văn Triệu' },
            { taikhoan: 'hr', matkhau: 'hashed_password_2', loaitk: 'M', sdt: '0123456789', email: '', info: 'HR' },
            { taikhoan: 'qc', matkhau: 'hashed_password_3', loaitk: 'U', sdt: '0912345678', email: '', info: 'QC' },
            { taikhoan: 'trieu', matkhau: 'hashed_password_4', loaitk: 'U', sdt: '0905551122', email: '', info: '' },
            { taikhoan: 'ketoan', matkhau: 'hashed_password_5', loaitk: 'M', sdt: '0333444555', email: '', info: 'Kế Toán' },
            { taikhoan: 'admin2', matkhau: 'hashed_password_6', loaitk: 'U', sdt: '0777888999', email: 'trieu230703@gmail.com', info: '' }
        ];

        let currentData = [...mockAccounts]; // Dữ liệu hiện tại để tìm kiếm và phân trang
        let currentPage = 1;
        const rowsPerPage = 5;

        const modal = document.getElementById('accountModal');
        const addAccountBtn = document.getElementById('addAccountBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const accountForm = document.getElementById('accountForm');
        const modalTitle = document.getElementById('modalTitle');
        const passwordGroup = document.getElementById('passwordGroup');
        const passwordHelp = document.getElementById('passwordHelp');
        const editModeTaikhoanInput = document.getElementById('editModeTaikhoan');


        function mapLoaiTK(loaitkChar) {
            switch (loaitkChar.toUpperCase()) {
                case 'A': return 'Quản trị';
                case 'M': return 'Quản lý';
                case 'U': return 'Người dùng';
                default: return loaitkChar;
            }
        }

        function renderTable(dataToRender) {
            const tableBody = document.getElementById('accountsTableBody');
            tableBody.innerHTML = ''; // Xóa dữ liệu cũ

            if (!dataToRender || dataToRender.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-gray-500">Không tìm thấy tài khoản nào.</td></tr>';
                return;
            }
            
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            const paginatedData = dataToRender.slice(startIndex, endIndex);


            paginatedData.forEach(account => {
                const row = `
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">${account.taikhoan}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">${account.info}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">${mapLoaiTK(account.loaitk)}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">${account.sdt || 'N/A'}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">${account.email || 'N/A'}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <button class="action-button edit-button" onclick="openEditModal('${account.taikhoan}')"><i class="fas fa-edit"></i> Sửa</button>
                            <button class="action-button delete-button" onclick="deleteAccount('${account.taikhoan}')"><i class="fas fa-trash"></i> Xóa</button>
                            <button class="action-button reset-password-button" onclick="resetPassword('${account.taikhoan}')"><i class="fas fa-key"></i> Reset Mật Khẩu</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
            renderPagination(dataToRender.length);
        }
        
        function renderPagination(totalItems) {
            const pageNumbersContainer = document.getElementById('pageNumbers');
            pageNumbersContainer.innerHTML = '';
            const totalPages = Math.ceil(totalItems / rowsPerPage);

            const prevButton = document.getElementById('prevPage');
            const nextButton = document.getElementById('nextPage');

            prevButton.classList.toggle('disabled:opacity-50', currentPage === 1);
            prevButton.disabled = currentPage === 1;
            nextButton.classList.toggle('disabled:opacity-50', currentPage === totalPages || totalPages === 0);
            nextButton.disabled = currentPage === totalPages || totalPages === 0;

            // Simple page numbers: First, current, last and ellipsis if needed
             const maxVisiblePages = 5; // Max number of page buttons to show

            if (totalPages <= 1) {
                pageNumbersContainer.innerHTML = ''; // No pagination needed for 0 or 1 page
                return;
            }
            
            let startPage, endPage;
            if (totalPages <= maxVisiblePages) {
                startPage = 1;
                endPage = totalPages;
            } else {
                const maxPagesBeforeCurrentPage = Math.floor(maxVisiblePages / 2);
                const maxPagesAfterCurrentPage = Math.ceil(maxVisiblePages / 2) - 1;
                if (currentPage <= maxPagesBeforeCurrentPage) {
                    startPage = 1;
                    endPage = maxVisiblePages;
                } else if (currentPage + maxPagesAfterCurrentPage >= totalPages) {
                    startPage = totalPages - maxVisiblePages + 1;
                    endPage = totalPages;
                } else {
                    startPage = currentPage - maxPagesBeforeCurrentPage;
                    endPage = currentPage + maxPagesAfterCurrentPage;
                }
            }

            if (startPage > 1) {
                 pageNumbersContainer.appendChild(createPageButton(1));
                if (startPage > 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
                    ellipsis.textContent = '...';
                    pageNumbersContainer.appendChild(ellipsis);
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                pageNumbersContainer.appendChild(createPageButton(i));
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
                    ellipsis.textContent = '...';
                    pageNumbersContainer.appendChild(ellipsis);
                }
                pageNumbersContainer.appendChild(createPageButton(totalPages));
            }
        }

        function createPageButton(pageNumber) {
            const pageButton = document.createElement('a');
            pageButton.href = '#';
            pageButton.textContent = pageNumber;
            pageButton.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50';
            if (pageNumber === currentPage) {
                pageButton.classList.add('z-10', 'bg-indigo-50', 'border-indigo-500', 'text-indigo-600');
                pageButton.setAttribute('aria-current', 'page');
            }
            pageButton.onclick = (e) => {
                e.preventDefault();
                currentPage = pageNumber;
                renderTable(currentData);
            };
            return pageButton;
        }
        
        document.getElementById('prevPage').onclick = (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderTable(currentData);
            }
        };

        document.getElementById('nextPage').onclick = (e) => {
            e.preventDefault();
            const totalPages = Math.ceil(currentData.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable(currentData);
            }
        };


        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            
            currentData = mockAccounts.filter(account => {
                return account.taikhoan.toLowerCase().includes(filter) ||
                       account.info.toLowerCase().includes(filter) ||
                       (account.email && account.email.toLowerCase().includes(filter)) ||
                       (account.sdt && account.sdt.toLowerCase().includes(filter));
            });
            currentPage = 1; // Reset to first page on search
            renderTable(currentData);
        }

        addAccountBtn.onclick = function() {
            modalTitle.textContent = 'Thêm Tài Khoản Mới';
            accountForm.reset();
            document.getElementById('taikhoan').disabled = false;
            passwordGroup.style.display = 'block';
            passwordHelp.style.display = 'none';
            document.getElementById('matkhau').required = true;
            editModeTaikhoanInput.value = '';
            modal.style.display = "block";
        }

        closeModalBtn.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        accountForm.onsubmit = function(event) {
            event.preventDefault();
            const taikhoan = document.getElementById('taikhoan').value;
            const matkhau = document.getElementById('matkhau').value;
            const info = document.getElementById('info').value;
            const loaitk = document.getElementById('loaitk').value;
            const sdt = document.getElementById('sdt').value;
            const email = document.getElementById('email').value;
            const editTaikhoan = editModeTaikhoanInput.value;

            if (editTaikhoan) { // Chế độ sửa
                const index = mockAccounts.findIndex(acc => acc.taikhoan === editTaikhoan);
                if (index !== -1) {
                    mockAccounts[index].info = info;
                    mockAccounts[index].loaitk = loaitk;
                    mockAccounts[index].sdt = sdt;
                    mockAccounts[index].email = email;
                    if (matkhau) { // Chỉ cập nhật mật khẩu nếu được nhập
                        mockAccounts[index].matkhau = 'hashed_' + matkhau; // Giả lập hash
                        alert(`Đã cập nhật tài khoản ${editTaikhoan} và thay đổi mật khẩu.`);
                    } else {
                        alert(`Đã cập nhật tài khoản ${editTaikhoan}. Mật khẩu không đổi.`);
                    }
                }
            } else { // Chế độ thêm mới
                 if (mockAccounts.find(acc => acc.taikhoan === taikhoan)) {
                    alert('Tài khoản đã tồn tại!');
                    return;
                }
                const newAccount = { taikhoan, matkhau: 'hashed_' + matkhau, info, loaitk, sdt, email };
                mockAccounts.push(newAccount);
                alert(`Đã thêm tài khoản ${taikhoan}.`);
            }
            
            currentData = [...mockAccounts]; // Cập nhật lại currentData sau khi thêm/sửa
            searchTable(); // Để áp dụng lại filter và phân trang
            modal.style.display = "none";
        }
        
        function openEditModal(taikhoan) {
            const account = mockAccounts.find(acc => acc.taikhoan === taikhoan);
            if (!account) return;

            modalTitle.textContent = 'Sửa Tài Khoản';
            editModeTaikhoanInput.value = account.taikhoan; // Lưu tài khoản gốc

            document.getElementById('taikhoan').value = account.taikhoan;
            document.getElementById('taikhoan').disabled = true; // Không cho sửa tên tài khoản (PK)
            
            document.getElementById('matkhau').value = ''; // Để trống mật khẩu
            document.getElementById('matkhau').required = false; // Mật khẩu không bắt buộc khi sửa
            passwordGroup.style.display = 'block';
            passwordHelp.style.display = 'block';


            document.getElementById('info').value = account.info;
            document.getElementById('loaitk').value = account.loaitk;
            document.getElementById('sdt').value = account.sdt || '';
            document.getElementById('email').value = account.email || '';
            
            modal.style.display = "block";
        }

        function deleteAccount(taikhoan) {
            if (confirm(`Bạn có chắc chắn muốn xóa tài khoản "${taikhoan}" không?`)) {
                const index = mockAccounts.findIndex(acc => acc.taikhoan === taikhoan);
                if (index > -1) {
                    mockAccounts.splice(index, 1);
                    currentData = [...mockAccounts]; // Cập nhật lại currentData
                    searchTable(); // Render lại bảng
                    alert(`Đã xóa tài khoản ${taikhoan}.`);
                }
            }
        }

        function resetPassword(taikhoan) {
            if (confirm(`Bạn có chắc chắn muốn đặt lại mật khẩu cho tài khoản "${taikhoan}" không? Một mật khẩu mới sẽ được tạo (hoặc bạn sẽ được yêu cầu nhập).`)) {
                // Trong thực tế, bạn sẽ gọi API để server xử lý việc này.
                // Ở đây chỉ mô phỏng:
                const newPass = prompt(`Đặt lại mật khẩu cho ${taikhoan}. Nhập mật khẩu mới:`);
                if (newPass) {
                     const index = mockAccounts.findIndex(acc => acc.taikhoan === taikhoan);
                     if (index !== -1) {
                        mockAccounts[index].matkhau = 'hashed_' + newPass; // Giả lập hash
                        alert(`Đã đặt lại mật khẩu cho tài khoản ${taikhoan}.`);
                     }
                } else if (newPass === "") {
                     alert("Mật khẩu không được để trống.");
                } else {
                    alert("Hủy thao tác đặt lại mật khẩu.");
                }
            }
        }

        // Tải dữ liệu ban đầu và render bảng
        document.addEventListener('DOMContentLoaded', () => {
            renderTable(currentData);
        });
    </script>
</body>
</html>


  @endsection