@extends('layouts.admin')

@section('title', 'Email - Workspace')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold text-dark" style="font-family: 'Poppins', sans-serif; font-size: 24px; color: #012970 !important;">Email</h1>
            <nav>
                <ol class="breadcrumb mb-0 mt-1" style="font-size: 12px; font-family: 'Poppins';">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Apps</li>
                    <li class="breadcrumb-item active">Email</li>
                </ol>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-3 shadow-sm" role="alert" style="font-size: 13px;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
        <div class="row g-0">
            
            <div class="col-xl-3 col-lg-4 border-end border-light-subtle py-4" style="min-height: 700px;">
                <div class="px-3 mb-4">
                    <button type="button" class="btn btn-primary w-100 py-2.5 rounded-3 fw-medium d-flex align-items-center justify-content-center gap-2 text-white" style="background-color: #3b5dfd; border: none; font-size: 14px; font-family: 'Poppins';" data-bs-toggle="modal" data-bs-target="#composeEmailModal">
                        <i class="bi bi-pencil-square" style="font-size: 16px;"></i> Compose
                    </button>
                </div>

                <div class="list-group list-group-flush gap-1 mb-4" style="font-size: 14.5px; font-family: 'Poppins', sans-serif;">
                    <a href="{{ route('admin.emails.index', ['folder' => 'inbox']) }}" class="list-group-item list-group-item-action d-flex align-items-center py-2.5 px-4 border-0 {{ $folder == 'inbox' ? 'active-niceadmin fw-medium' : 'bg-transparent text-secondary' }}">
                        <i class="bi bi-hdd-rack me-3 fs-5"></i> Inbox
                        <span class="badge ms-auto rounded-pill bg-primary px-2 py-1" style="font-size: 11px; background-color: #3b5dfd !important;">{{ $totalInbox }}</span>
                    </a>
                    <a href="{{ route('admin.emails.index', ['folder' => 'starred']) }}" class="list-group-item list-group-item-action d-flex align-items-center py-2.5 px-4 border-0 {{ $folder == 'starred' ? 'active-niceadmin fw-medium' : 'bg-transparent text-secondary' }}">
                        <i class="bi bi-star me-3 fs-5"></i> Starred
                    </a>
                    <a href="{{ route('admin.emails.index', ['folder' => 'sent']) }}" class="list-group-item list-group-item-action d-flex align-items-center py-2.5 px-4 border-0 {{ $folder == 'sent' ? 'active-niceadmin fw-medium' : 'bg-transparent text-secondary' }}">
                        <i class="bi bi-send me-3 fs-5"></i> Sent
                    </a>
                    <a href="{{ route('admin.emails.index', ['folder' => 'drafts']) }}" class="list-group-item list-group-item-action d-flex align-items-center py-2.5 px-4 border-0 {{ $folder == 'drafts' ? 'active-niceadmin fw-medium' : 'bg-transparent text-secondary' }}">
                        <i class="bi bi-file-earmark me-3 fs-5"></i> Drafts
                        <span class="badge ms-auto rounded-pill bg-primary px-2 py-1" style="font-size: 11px; background-color: #3b5dfd !important;">{{ $totalDrafts }}</span>
                    </a>
                    <a href="{{ route('admin.emails.index', ['folder' => 'spam']) }}" class="list-group-item list-group-item-action d-flex align-items-center py-2.5 px-4 border-0 {{ $folder == 'spam' ? 'active-niceadmin fw-medium' : 'bg-transparent text-secondary' }}">
                        <i class="bi bi-exclamation-circle me-3 fs-5"></i> Spam
                        <span class="badge ms-auto rounded-pill px-2 py-1 text-white" style="font-size: 11px; background-color: #f0a000 !important;">{{ $totalSpam }}</span>
                    </a>
                    <a href="{{ route('admin.emails.index', ['folder' => 'trash']) }}" class="list-group-item list-group-item-action d-flex align-items-center py-2.5 px-4 border-0 {{ $folder == 'trash' ? 'active-niceadmin fw-medium' : 'bg-transparent text-secondary' }}">
                        <i class="bi bi-trash3 me-3 fs-5"></i> Trash
                    </a>
                </div>

                <hr class="text-black-50 opacity-10 my-4">
                <div class="px-4 mb-2 text-muted fw-bold text-uppercase tracking-wider" style="font-size: 11px; font-family: 'Poppins'; letter-spacing: 0.8px;">Labels</div>
                <div class="d-flex flex-column gap-1" style="font-size: 14px; font-family: 'Poppins';">
                    <div class="d-flex align-items-center gap-2 px-4 py-2 text-secondary"><span class="rounded-circle bg-success" style="width: 8px; height: 8px;"></span> Work</div>
                    <div class="d-flex align-items-center gap-2 px-4 py-2 text-secondary"><span class="rounded-circle bg-danger" style="width: 8px; height: 8px;"></span> Important</div>
                    <div class="d-flex align-items-center gap-2 px-4 py-2 text-secondary"><span class="rounded-circle bg-primary" style="width: 8px; height: 8px; background-color: #3b5dfd !important;"></span> Personal</div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-8 bg-white d-flex flex-column">
                
                <div class="py-3 px-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-3" style="background-color: #ffffff;">
                    
                    <div class="d-flex align-items-center gap-3 functionality-actions text-secondary">
                        <input type="checkbox" class="form-check-input shadow-none cursor-pointer border-secondary border-opacity-50" id="selectAllEmails" style="width: 18px; height: 18px; border-radius: 4px;">
                        
                        <button class="btn p-1 border-0 bg-transparent text-secondary text-opacity-75" onclick="window.location.reload()" title="Refresh">
                            <i class="bi bi-arrow-clockwise fs-5 fw-bold"></i>
                        </button>
                        <button class="btn p-1 border-0 bg-transparent text-secondary text-opacity-75" title="Archive">
                            <i class="bi bi-archive fs-5"></i>
                        </button>
                        <button class="btn p-1 border-0 bg-transparent text-secondary text-opacity-75" id="deleteSelectedBtn" title="Delete Selected" style="display: none;">
                            <i class="bi bi-trash3 fs-5"></i>
                        </button>
                        
                        <div class="dropdown">
                            <button class="btn p-1 border-0 bg-transparent text-secondary text-opacity-75 shadow-none" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-start shadow border border-light-subtle rounded-3 py-2 animate-fade-in" aria-labelledby="dropdownMenuButton" style="font-size: 13.5px; font-family: 'Poppins'; min-width: 180px;">
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2.5 text-secondary" href="#" onclick="submitBulkAction('mark_all_read')">
                                        <i class="bi bi-check2-all text-primary fs-5"></i> Mark all as read
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2.5 text-secondary" href="#" onclick="submitBulkAction('star_all')">
                                        <i class="bi bi-star fs-5"></i> Star all
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2.5 text-secondary" href="#">
                                        <i class="bi bi-folder fs-5"></i> Move to folder
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <form id="bulkActionForm" action="{{ route('admin.emails.bulkAction') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="action" id="bulkActionType">
                        <input type="hidden" name="current_folder" value="{{ $folder }}">
                        <div id="bulkSelectedIdsContainer"></div>
                    </form>
                    
                    <div class="flex-grow-1 mx-md-4" style="max-width: 480px;">
                        <form action="{{ route('admin.emails.index') }}" method="GET">
                            <input type="hidden" name="folder" value="{{ $folder }}">
                            <div class="input-group rounded-2 px-3 py-1.5" style="background-color: #f4f6fa;">
                                <span class="input-group-text bg-transparent border-0 text-muted p-0 pe-2"><i class="bi bi-search" style="font-size: 14px;"></i></span>
                                <input type="text" name="search" class="form-control bg-transparent border-0 p-0 shadow-none text-secondary" placeholder="Search emails..." value="{{ $search }}" style="font-size: 13.5px; font-family: 'Poppins';">
                                @if($search)
                                    <a href="{{ route('admin.emails.index', ['folder' => $folder]) }}" class="text-muted ms-2 my-auto text-decoration-none" style="font-size: 12px;">✕ Clear</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    
                    <div class="d-flex align-items-center gap-3 Search-Pagination-Wrapper">
                        <div class="text-secondary opacity-75 fw-normal" style="font-size: 13.5px; font-family: 'Poppins';">
                            {{ $emails->firstItem() ?? 0 }}-{{ $emails->lastItem() ?? 0 }} of {{ $emails->total() }}
                        </div>
                        <div class="btn-group rounded shadow-none gap-1">
                            <a href="{{ $emails->previousPageUrl() }}" class="btn btn-white bg-transparent border border-light-subtle py-1 px-2.5 text-secondary rounded-2 {{ $emails->onFirstPage() ? 'disabled text-opacity-20' : '' }}">
                                <i class="bi bi-chevron-left" style="-webkit-text-stroke: 0.5px;"></i>
                            </a>
                            <a href="{{ $emails->nextPageUrl() }}" class="btn btn-white bg-transparent border border-light-subtle py-1 px-2.5 text-secondary rounded-2 {{ !$emails->hasMorePages() ? 'disabled text-opacity-20' : '' }}">
                                <i class="bi bi-chevron-right" style="-webkit-text-stroke: 0.5px;"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="dynamic-view-viewpane flex-grow-1" id="email-viewpane-container">
                    @forelse($emails as $mail)
                        @php
                            $labelColor = match($mail->label) {
                                'Important' => 'bg-danger text-white',
                                'Social' => 'bg-info text-white',
                                default => 'bg-success text-white'
                            };
                        @endphp
                        
                        <div class="niceadmin-email-row d-flex align-items-center gap-3 p-3 px-4 border-bottom position-relative" 
                             style="cursor: pointer; background-color: {{ $mail->is_read ? '#ffffff' : '#f8faff' }};"
                             data-id="{{ $mail->id }}"
                             onclick="openReadingPane('{{ $mail->id }}', '{{ addslashes($mail->sender_name) }}', '{{ $mail->sender_email }}', '{{ addslashes($mail->subject) }}', `{!! $mail->message !!}`, '{{ $mail->created_at->format('M d, Y, h:i A') }}', '{{ $mail->label }}')">
                            
                            <div class="d-flex align-items-center gap-2 flex-shrink-0" onclick="event.stopPropagation();">
                                <input type="checkbox" class="form-check-input shadow-none border-secondary border-opacity-40 email-checkbox" value="{{ $mail->id }}" style="width: 17px; height: 17px; border-radius: 4px;">
                                <i class="bi {{ $mail->is_starred ? 'bi-star-fill text-warning' : 'bi-star text-muted opacity-40' }} toggle-star" style="cursor: pointer; font-size: 16px;"></i>
                            </div>

                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-medium text-uppercase flex-shrink-0" style="width: 38px; height: 38px; font-size: 13px; font-family: 'Poppins';">
                                {{ substr($mail->sender_name, 0, 2) }}
                            </div>

                            <div class="flex-grow-1 min-width-0 row g-1 align-items-center m-0">
                                <div class="col-md-3 col-12 p-0 text-truncate">
                                    <span class="{{ $mail->is_read ? 'fw-normal' : 'fw-bold' }} text-dark text-truncate d-block" style="font-size: 14px; font-family: 'Poppins';">{{ $mail->sender_name }}</span>
                                </div>
                                <div class="col-md-9 col-12 p-0 text-truncate d-flex align-items-center gap-1.5">
                                    <span class="{{ $mail->is_read ? 'fw-normal' : 'fw-semibold' }} text-dark text-truncate" style="font-size: 13.5px; font-family: 'Poppins';">{{ $mail->subject }}</span>
                                    <span class="text-muted opacity-60 text-truncate d-none d-sm-inline" style="font-size: 13.5px;"> — {{ strip_tags($mail->message) }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3 flex-shrink-0 ms-auto">
                                <span class="badge {{ $labelColor }} d-none d-sm-inline-block" style="font-size: 10.5px; font-family: 'Poppins'; padding: 4px 8px; border-radius: 4px; font-weight: 500;">{{ $mail->label }}</span>
                                <i class="bi bi-paperclip text-muted opacity-40 d-none d-md-block fs-5"></i>
                                <span class="text-muted font-monospace text-end d-none d-sm-inline" style="font-size: 12px; min-width: 60px;">{{ $mail->created_at->format('h:i A') }}</span>
                                
                                <button class="btn btn-link p-0 text-danger border-0 opacity-0 action-trash-btn shadow-none lh-1" onclick="event.stopPropagation(); if(confirm('Move message to Trash?')) document.getElementById('trash-form-{{ $mail->id }}').submit();">
                                    <i class="bi bi-trash3 fs-5"></i>
                                </button>
                                <form id="trash-form-{{ $mail->id }}" action="{{ route('admin.emails.destroy', $mail->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted bg-white" style="font-family: 'Poppins'; font-size: 13px; font-style: italic;">
                            <i class="bi bi-envelope-open d-block mb-2 text-secondary fs-2"></i>
                            No messages found in this folder.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="composeEmailModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow rounded-3">
                <div class="modal-header bg-light py-3 border-bottom">
                    <h5 class="modal-title fw-bold text-dark" style="font-size: 14px; font-family: 'Poppins';"><i class="bi bi-pencil-square me-2 text-primary"></i>New Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.emails.store') }}" method="POST" id="composeEmailForm">
                    @csrf
                    <div class="modal-body p-4" style="font-size: 13px; font-family: 'Poppins';">
                        <div class="mb-2 position-relative border-bottom pb-1">
                            <div class="d-flex align-items-center">
                                <label class="text-secondary fw-semibold me-2" style="width: 50px;">To:</label>
                                <input type="email" name="sender_email" class="form-control border-0 bg-transparent p-0 shadow-none" placeholder="recipient@example.com" required>
                            </div>
                        </div>
                        <div class="mb-3 border-bottom pb-1">
                            <div class="d-flex align-items-center">
                                <label class="text-secondary fw-semibold me-2" style="width: 50px;">Subject:</label>
                                <input type="text" name="subject" class="form-control border-0 bg-transparent p-0 shadow-none" placeholder="Add a subject" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Sender Full Name</label>
                                <input type="text" name="sender_name" class="form-control shadow-none" placeholder="e.g., Sarah Wilson" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Category Tag</label>
                                <select name="label" class="form-select shadow-none" required>
                                    <option value="Work" selected>Work</option>
                                    <option value="Important">Important</option>
                                    <option value="Social">Social</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold text-secondary mb-2">Message Body</label>
                            <div id="quill-editor" class="bg-white rounded-2" style="height: 220px;"></div>
                            <input type="hidden" name="message" id="hidden_message_body">
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-2 border-top d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-light border text-secondary rounded shadow-sm"><i class="bi bi-file-earmark shadow-none"></i> Save Draft</button>
                        <div>
                            <button type="button" class="btn btn-sm btn-secondary rounded me-1" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary rounded px-4" style="background-color: #4154f1; border: none;">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let fallbackInboxHTML = '';

        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Write your content here...',
            modules: { toolbar: [['bold', 'italic', 'underline'], ['link', 'image'], [{ 'list': 'ordered'}, { 'list': 'bullet' }]] }
        });

        document.getElementById('composeEmailForm').onsubmit = function() {
            document.getElementById('hidden_message_body').value = quill.root.innerHTML;
        };

        // Fungsi Kelola Checkbox
        const selectAll = document.getElementById('selectAllEmails');
        const checkboxes = document.querySelectorAll('.email-checkbox');
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            toggleDeleteButton();
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', toggleDeleteButton);
        });

        function toggleDeleteButton() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            deleteSelectedBtn.style.display = anyChecked ? 'inline-block' : 'none';
        }

        // Jalankan Bulk Action
        function submitBulkAction(actionType) {
            document.getElementById('bulkActionType').value = actionType;
            const container = document.getElementById('bulkSelectedIdsContainer');
            container.innerHTML = ''; // Reset

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = cb.value;
                    container.appendChild(input);
                }
            });

            document.getElementById('bulkActionForm').submit();
        }

        function openReadingPane(id, senderName, senderEmail, subject, message, dateStr, label) {
            const container = document.getElementById('email-viewpane-container');
            if (!fallbackInboxHTML) fallbackInboxHTML = container.innerHTML;

            let labelClass = 'bg-success text-white';
            if(label === 'Important') labelClass = 'bg-danger text-white';
            if(label === 'Social') labelClass = 'bg-info text-white';

            container.innerHTML = `
                <div class="p-4 bg-white animate-fade-in" style="font-family: 'Poppins', sans-serif;">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                        <button class="btn btn-light btn-sm px-3 border d-flex align-items-center gap-1.5" onclick="closeReadingPane()" style="font-size: 13px;">
                            <i class="bi bi-arrow-left"></i> Back to Inbox
                        </button>
                    </div>
                    <h3 class="fw-bold text-dark mb-3" style="font-size: 20px;">${subject}</h3>
                    <p class="text-secondary mb-4" style="font-size: 13px;">From: <strong>${senderName}</strong> &lt;${senderEmail}&gt; - ${dateStr}</p>
                    <div class="py-2 text-dark ql-editor">${message}</div>
                </div>
            `;
        }

        function closeReadingPane() {
            if (fallbackInboxHTML) {
                document.getElementById('email-viewpane-container').innerHTML = fallbackInboxHTML;
                fallbackInboxHTML = '';
            }
        }
    </script>

    <style>
        /* CSS State Tampilan */
        .active-niceadmin { background-color: #eff2fe !important; color: #3b5dfd !important; font-weight: 500; border-radius: 0 24px 24px 0 !important; }
        .list-group-item-action:hover { background-color: #f4f6fa !important; color: #3b5dfd !important; }
        
        .niceadmin-email-row { transition: background-color 0.12s ease; }
        .niceadmin-email-row:hover { background-color: #f7f9fc !important; }
        .niceadmin-email-row:hover .action-trash-btn { opacity: 1 !important; }
        .niceadmin-email-row:hover .text-muted.font-monospace { display: none !important; }

        .min-width-0 { min-width: 0; }
        .cursor-pointer { cursor: pointer; }
        .animate-fade-in { animation: fadeInEffect 0.2s ease-out forwards; }
        @keyframes fadeInEffect { from { opacity: 0; transform: translateY(2px); } to { opacity: 1; transform: translateY(0); } }

        /* Style Kustom Menu Dropdown Titik Tiga Agar Mirip Gambar */
        .dropdown-menu { border-radius: 8px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; }
        .dropdown-item:hover { background-color: #f4f6fa !important; color: #3b5dfd !important; }
    </style>

@endsection