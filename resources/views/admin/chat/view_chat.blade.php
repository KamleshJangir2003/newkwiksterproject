<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kwikster|Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Mega Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords"
        content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="codedthemes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('Agent/assets/plugins/notifications/css/lobibox.min.css') }}" />
    <link href="{{ asset('Agent/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('Agent/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />

    <link href="{{ asset('Agent/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('Agent/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    {{-- <link href="{{asset('Agent/assets/css/pace.min.css')}}" rel="stylesheet"/>
<script src="{{asset('Agent/assets/js/pace.min.js')}}"></script> --}}
    <!-- Bootstrap CSS -->
    <link href="{{ asset('Agent/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Agent/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('Agent/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('Agent/assets/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('Agent/assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('Agent/assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('Agent/assets/css/header-colors.css') }}" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-KyZXEAg3QhqLMpG8r+Knujsl5/5hb7MFtW1hqPJzMEs=" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('3ef0092734ff41650c00', {
            cluster: 'ap2'
        });
    </script>
    <style>
        .chat-content {
            max-height: 440px;
            /* Adjust the height as needed */
            overflow-y: auto;
            padding: 15px;
            background-color: #f5f5f5;
            /* Optional: background color */
            border: 1px solid #ddd;
            /* Optional: border */
            border-radius: 4px;
            /* Optional: border radius */
            margin-top: 50px;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            text-align: center;
            justify-content: center;
            align-items: center;
            overflow: auto;
        }

        /* Enlarged image styles */
        .overlay img {
            max-width: 80%;
            max-height: 80%;
            border-radius: 50%;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .emoji-picker {
            display: none;
            border: 1px solid #ddd;
            background: #fff;
            position: absolute;
            z-index: 1000;
            padding: 10px;
            border-radius: 5px;
            max-width: 275px;
            max-height: 200px;
            overflow-y: auto;
        }

        .emoji-picker span {
            cursor: pointer;
            padding: 5px;
            font-size: 24px;
            transition: background 0.3s;
        }

        .emoji-picker span:hover {
            background: #f0f0f0;
        }

        .highlighted {
            background-color: rgb(255, 255, 147);
            /* Highlight color */
            border: 1px solid #ffa;
            /* Optional: border to make the highlight more visible */
        }

        .highlight {
            background-color: rgb(251, 255, 174);
            transition: background-color 1s ease;
        }

        .chat-user-online {
            position: relative;
            /* Ensure proper positioning context for ::before pseudo-element */
        }

        .chat-user-online::before {
            content: '';
            position: absolute;

        }

        .chat-user-online.inactive::before {
            bottom: 7px;
            left: 36px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            box-shadow: 0 0 0 2px #fff;
            background-color: orange;
            /* Change background color to orange for inactive status */
        }

        .dropdown-container {
            text-align: right;
            text-decoration: none;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .box-span {
            display: inline-block;
            padding: 5px;
            background-color: rgb(229, 226, 226);
            border-radius: 5px;
            color: black;
            max-width: 200px;
            /* Adjust as needed for your layout */
            word-wrap: break-word;
            /* Wrap long words */
        }
    </style>
    <style>
        .chat-wrapper {
            height: 100vh;
            /* Make the height 100% of the viewport height */
            max-height: 100vh;
            /* Ensure the height doesn't exceed the viewport height */
            overflow-y: auto;
            /* Enable vertical scrolling if needed */
        }

        .chat-list {
            max-height: 100%;
            /* Ensure the chat list doesn't exceed the wrapper's height */
            overflow-y: auto;
            /* Enable vertical scrolling if needed */
        }

        @media (min-width: 768px) {
            .chat-wrapper {
                height: 75vh;
                /* Adjust height for medium to large screens */
            }
        }

        @media (min-width: 992px) {
            .chat-wrapper {
                height: 85vh;
                /* Adjust height for large screens */
            }
        }

        @media (min-width: 1200px) {
            .chat-wrapper {
                height: 90vh;
                /* Adjust height for extra-large screens */
            }
        }
    </style>
    <style>
        .file-preview-container {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 10px;
        }

        .file-preview {
            max-width: 100px;
            max-height: 100px;
            display: block;
        }

        .lni.lni-close {
            font-size: 20px;
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
        }

        .badge_seen {
            position: absolute;
            top: 31px;
            right: 14px;
            /* Adjust as needed for positioning */
            z-index: 1;
            /* Ensure badge is above other content */
        }
    </style>

    <!--start page wrapper -->
    <div class="page-content">
        <div class="chat-wrapper">
            <div class="chat-sidebar">
                <div class="chat-sidebar-header">
                    <div class="d-flex align-items-center">
                        <div class="chat-user-online">
                            @php
                                if (!empty(session('admin_image'))) {
                                    $selfimage = asset('admin_image');
                                } else {
                                    $selfimage = asset('Agent/assets/blank_user_logo.jpg');
                                }

                            @endphp
                            <img src="{{ $selfimage }}" width="45" height="45" class="rounded-circle"
                                alt="" />
                        </div>
                        <div class="flex-grow-1 ms-2">
    <p class="mb-0">{{ $ID->name ?? 'N/A' }}</p>
</div>

                        <button type="button" onclick="window.location.href='{{ route('admin_index') }}'"
                            class="btn btn-dark"><i class="bx bx-share"></i>
                        </button>
                    </div>
                    <div class="mb-3"></div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-transparent"><i class='bx bx-search'></i></span>
                        <input type="text" id="search-input" class="form-control"
                            placeholder="People, groups, & messages">
                        <span class="input-group-text bg-transparent"><i class='bx bx-dialpad'></i></span>
                    </div>
                </div>
                <div class="chat-sidebar-content">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-Chats">
                            <div class="p-3">
                                <div class="meeting-button d-flex justify-content-between">
                                    <div class="dropdown"> <a href="#"
                                            class="btn btn-white btn-sm radius-30 dropdown-toggle dropdown-toggle-nocaret"
                                            data-bs-toggle="dropdown" data-display="static"><i
                                                class='bx bxs-edit me-2'></i>New Chat<i
                                                class='bx bxs-chevron-down ms-2'></i></a>
                                        <div class="dropdown-menu dropdown-menu-right"> <a class="dropdown-item"
                                                href="#" data-bs-toggle="modal" data-bs-target="#create_group">New
                                                Group Chat</a>
                                            <a class="dropdown-item" href="#">New Chat</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown mt-3"><a href="#"
                                        class="text-uppercase text-secondary dropdown-toggle dropdown-toggle-nocaret"
                                        data-bs-toggle="dropdown">Recent Chats <i class='bx bxs-chevron-down'></i></a>
                                </div>
                            </div>
                            <div class="chat-list" style="overflow-y: auto;">
                                <div class="list-group list-group-flush" id="chat-list">
                                    @if (!empty($filtered_groups))
                                        @foreach ($filtered_groups as $group)
                                            @php
                                                $name = $group->name;
                                                $image = !empty($group->image)
                                                    ? asset($group->image)
                                                    : asset('Agent/assets/blank_user_logo.jpg');
                                                $message = App\Models\ChMessage::where('group_id', $group->id)
                                                    ->orderBy('created_at', 'desc')
                                                    ->first();
                                            @endphp
                                            <a href="javascript:;" class="list-group-item group-item"
                                                data-group-id="{{ $group->id }}">
                                                <div class="d-flex">
                                                    <div>
                                                        <img src="{{ $image }}" width="42" height="42"
                                                            class="rounded-circle" alt="" />
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h6 class="mb-0 chat-title">{{ $name }}</h6>
                                                        @php
                                                            // Split the body into words
                                                            $body = isset($message->body) ? $message->body : '';
                                                            if (!empty($body)) {
                                                                // Split the body into words and HTML tags
                                                                $wordsAndTags = preg_split(
                                                                    '/(<[^>]+>|[\s]+)/',
                                                                    $body,
                                                                    -1,
                                                                    PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY,
                                                                );
                                                                $wordCount = 0;
                                                                $limitedWordsAndTags = [];

                                                                foreach ($wordsAndTags as $segment) {
                                                                    if (strip_tags($segment) !== '') {
                                                                        $words = explode(' ', $segment);
                                                                        foreach ($words as $word) {
                                                                            if ($wordCount < 3) {
                                                                                $limitedWordsAndTags[] = $word;
                                                                                $wordCount++;
                                                                            } else {
                                                                                break 2; // Break out of both loops
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $limitedWordsAndTags[] = $segment; // Add HTML tags directly
                                                                    }
                                                                }

                                                                // Join the limited words and tags back into a string
                                                                $limitedBody = implode(' ', $limitedWordsAndTags);

                                                                // Add ellipsis if the original body has more words
                                                                if (
                                                                    $wordCount < count(explode(' ', strip_tags($body)))
                                                                ) {
                                                                    $limitedBody .= ' ...';
                                                                }
                                                            } else {
                                                                $limitedBody = 'File & Image';
                                                            }
                                                        @endphp
                                                        <p class="mb-0 chat-msg">{{ $limitedBody }}</p>
                                                    </div>
                                                    @php
                                                        // Get the created_at timestamp
                                                        $createdAt = isset($message->created_at)
                                                            ? $message->created_at
                                                            : '';

                                                        // Calculate the difference in days, hours, and minutes
                                                        $diffDays = now()->diffInDays($createdAt);
                                                        $diffHours = now()->diffInHours($createdAt) - $diffDays * 24; // Remaining hours after subtracting full days
                                                        $diffMinutes =
                                                            now()->diffInMinutes($createdAt) -
                                                            $diffDays * 24 * 60 -
                                                            $diffHours * 60; // Remaining minutes after subtracting full days and hours

                                                        // Format the difference into 'x d x h' or 'x d x m' format
                                                        $timeDiff = '';
                                                        if ($diffDays > 0) {
                                                            $timeDiff .= $diffDays . 'd ';
                                                        }
                                                        if ($diffHours > 0) {
                                                            $timeDiff .= $diffHours . 'h ';
                                                        } elseif ($diffMinutes > 0 || empty($timeDiff)) {
                                                            $timeDiff .= $diffMinutes . 'm';
                                                        }

                                                        $check_seen = App\Models\ChMessage::where(
                                                            'group_id',
                                                            $group->id,
                                                        )->get();
                                                        $unreadCount = 0;
                                                        foreach ($check_seen as $item) {
                                                            if ($item) {
                                                                // Decode 'seen' JSON array if it exists
                                                                if ($item->seen == 0) {
                                                                    $unreadCount++;
                                                                } else {
                                                                    $seen = json_decode($item->seen ?? '[]', true);

                                                                    // Check if session agent ID is not in 'seen'
                                                                    if (!in_array($ID->id, $seen)) {
                                                                        $unreadCount++;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    @endphp

                                                    <div class="chat-time">{{ $timeDiff }}</div>
                                                    @if ($unreadCount !== 0)
                                                        <span class="badge bg-success badge_seen">{{ $unreadCount }}</span>
                                                    @endif
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                    @if (!empty($users))
                                        @foreach ($users as $user)
                                            @php
                                                $details = App\adminmodel\Users_detailsModal::where(
                                                    'ajent_id',
                                                    $user->id,
                                                )->first();
                                                $name = !empty($details->alise_name)
                                                    ? $details->alise_name
                                                    : $user->name;
                                                if (!empty($ID) && $user->team_id == $ID->id) {
    $name = 'You';
}

                                                $image = !empty($user->image)
                                                    ? asset($user->image)
                                                    : asset('Agent/assets/blank_user_logo.jpg');

                                                $message = App\Models\ChMessage::where(function ($query) use (
                                                    $user,
                                                    $ID,
                                                ) {
                                                    $query->where('to_id', $user->id)->where('from_id', $ID->id);
                                                })
                                                    ->orWhere(function ($query) use ($user, $ID) {
                                                        $query->where('from_id', $user->id)->where('to_id', $ID->id);
                                                    })
                                                    ->orderBy('created_at', 'desc')
                                                    ->latest()
                                                    ->first();
                                            @endphp
                                            <a href="javascript:;" class="list-group-item user-item"
                                                data-user-id="{{ $user->id }}">
                                                <div class="d-flex">
                                                    @php
                                                        $currentDate = date('Y-m-d');
                                                        // Fetch the attendance record for the current date
                                                        $attendance = App\Models\Attendance::where('emp_id', $user->id)
                                                            ->where('date', $currentDate)
                                                            ->first();
                                                        if ($attendance) {
                                                            // If attendance record exists for today
                                                            $loginTime = Carbon\Carbon::parse(
                                                                $attendance->login,
                                                                'America/New_York',
                                                            )->timezone('Asia/Kolkata');
                                                            $login = $loginTime->timestamp;
                                                            $exitTime = Carbon\Carbon::parse(
                                                                $attendance->exit_time,
                                                                'Asia/Kolkata',
                                                            )->timezone('Asia/Kolkata');
                                                            $logout = $exitTime->timestamp;
                                                            // Compare login and logout times
                                                            if ($login > $logout) {
                                                                $status = 'Active';
                                                            } else {
                                                                $status = 'Inactive';
                                                            }
                                                        } else {
                                                            // If no attendance record found for today
                                                            $status = 'Inactive'; // Assuming inactive if no record found
                                                        }
                                                    @endphp

                                                    <div
                                                        class="chat-user-online @if ($status == 'Inactive') inactive @endif">
                                                        <img src="{{ $image }}" width="42" height="42"
                                                            class="rounded-circle" alt="" />
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h6 class="mb-0 chat-title">{{ $name }}</h6>
                                                        @php
                                                            $message_body = isset($message->body) ? $message->body : '';
                                                            if (!empty($message_body)) {
                                                                // Split the body into words and HTML tags
                                                                $wordsAndTags = preg_split(
                                                                    '/(<[^>]+>|[\s]+)/',
                                                                    $message_body,
                                                                    -1,
                                                                    PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY,
                                                                );
                                                                $wordCount = 0;
                                                                $limitedWordsAndTags = [];

                                                                foreach ($wordsAndTags as $segment) {
                                                                    if (strip_tags($segment) !== '') {
                                                                        $words = explode(' ', $segment);
                                                                        foreach ($words as $word) {
                                                                            if ($wordCount < 3) {
                                                                                $limitedWordsAndTags[] = $word;
                                                                                $wordCount++;
                                                                            } else {
                                                                                break 2; // Break out of both loops
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $limitedWordsAndTags[] = $segment; // Add HTML tags directly
                                                                    }
                                                                }

                                                                // Join the limited words and tags back into a string
                                                                $limitedBody = implode(' ', $limitedWordsAndTags);

                                                                // Add ellipsis if the original body has more words
                                                                if (
                                                                    $wordCount < count(explode(' ', strip_tags($message_body)))
                                                                ) {
                                                                    $limitedBody .= ' ...';
                                                                }
                                                            } else {
                                                                $limitedBody = 'File & Image';
                                                            }
                                                        @endphp
                                                        <p class="mb-0 chat-msg">{{ $limitedBody }}</p>
                                                    </div>
                                                    @php
                                                        // Get the created_at timestamp
                                                        $createdAt = isset($message->created_at)
                                                            ? $message->created_at
                                                            : '';

                                                        // Calculate the difference in days, hours, and minutes
                                                        $diffDays = now()->diffInDays($createdAt);
                                                        $diffHours = now()->diffInHours($createdAt) - $diffDays * 24; // Remaining hours after subtracting full days
                                                        $diffMinutes =
                                                            now()->diffInMinutes($createdAt) -
                                                            $diffDays * 24 * 60 -
                                                            $diffHours * 60; // Remaining minutes after subtracting full days and hours

                                                        // Format the difference into 'x d x h' or 'x d x m' format
                                                        $timeDiff = '';
                                                        if ($diffDays > 0) {
                                                            $timeDiff .= $diffDays . 'd ';
                                                        }
                                                        if ($diffHours > 0) {
                                                            $timeDiff .= $diffHours . 'h ';
                                                        } elseif ($diffMinutes > 0 || empty($timeDiff)) {
                                                            $timeDiff .= $diffMinutes . 'm';
                                                        }

                                                        $unreaduserCount = App\Models\ChMessage::where(
                                                            'from_id',
                                                            $user->id,
                                                        )
                                                            ->where('to_id', $ID->id)
                                                            ->where('seen', 0)
                                                            ->count();
                                                    @endphp

                                                    <div class="chat-time">{{ $timeDiff }}</div>
                                                    @if ($unreaduserCount !== 0)
                                                        <span class="badge bg-success badge_seen">{{ $unreaduserCount }}</span>
                                                    @endif
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-window">
                @if (!empty($users))
                    @foreach ($users as $user)
                        @php
                            $messages = App\Models\ChMessage::where(function ($query) use ($user, $ID) {
                                $query->where('to_id', $user->id)->where('from_id', $ID->id);
                            })
                                ->orWhere(function ($query) use ($user, $ID) {
                                    $query->where('from_id', $user->id)->where('to_id', $ID->id);
                                })
                                ->orderBy('created_at', 'asc')
                                ->get();
                        @endphp
                        <div class="chat-content-container user-chat" id="chat-{{ $user->id }}"
                            style="display: none;">
                            <div class="chat-header d-flex align-items-center">
                                <div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i></div>
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="chat-user-online">
                                            @php
                                                if (!empty($user->image)) {
                                                    $image_user = asset($user->image);
                                                } else {
                                                    $image_user = asset('Agent/assets/blank_user_logo.jpg');
                                                }
                                            @endphp
                                            <a href="javascript:;" class="show-profile-picture">
                                                <img src="{{ $image_user }}" width="45" height="45"
                                                    class="rounded-circle" alt="Profile Picture" />
                                            </a>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            @php
                                                $head_user = App\adminmodel\Users_detailsModal::where(
                                                    'ajent_id',
                                                    $user->id,
                                                )->first();
                                                if (!empty($head_user->alise_name)) {
                                                    $head_user_name = $head_user->alise_name;
                                                } else {
                                                    $head_user_name = $user->name;
                                                }
                                            @endphp
                                            <p class="mb-0" style="font-weight: 500;">{{ $head_user_name }}
                                            </p>
                                            <div class="list-inline d-sm-flex mb-0 d-none">
                                                <a href="javascript:;"
                                                    class="list-inline-item d-flex align-items-center text-secondary">
                                                    @php
                                                        $currentDate = date('Y-m-d');
                                                        // Fetch the attendance record for the current date
                                                        $attendance = App\Models\Attendance::where('emp_id', $user->id)
                                                            ->where('date', $currentDate)
                                                            ->first();
                                                        if ($attendance) {
                                                            // If attendance record exists for today
                                                            $loginTime = Carbon\Carbon::parse(
                                                                $attendance->login,
                                                                'America/New_York',
                                                            )->timezone('Asia/Kolkata');
                                                            $login = $loginTime->timestamp;
                                                            $exitTime = Carbon\Carbon::parse(
                                                                $attendance->exit_time,
                                                                'Asia/Kolkata',
                                                            )->timezone('Asia/Kolkata');
                                                            $logout = $exitTime->timestamp;
                                                            $currentDateTime = Carbon\Carbon::now('Asia/Kolkata');

                                                            // Calculate difference
                                                            $timeDiff = $exitTime->diff($currentDateTime);

                                                            // Format the difference
                                                            $formattedDiff = '';
                                                            $status = 'Inactive'; // Default status

                                                            if (isset($timeDiff)) {
                                                                if ($timeDiff->days > 0) {
                                                                    $formattedDiff .= $timeDiff->days . ' days ';
                                                                }
                                                                if ($timeDiff->h > 0) {
                                                                    $formattedDiff .= $timeDiff->h . ' hours ';
                                                                }
                                                                if ($timeDiff->i > 0) {
                                                                    $formattedDiff .= $timeDiff->i . ' minutes';
                                                                }
                                                                if ($login > $logout) {
                                                                    $status = 'Active';
                                                                } else {
                                                                    $status = 'Inactive';
                                                                }
                                                            }
                                                        } else {
                                                            // If no attendance record found for today
                                                            $status = 'Inactive'; // Assuming inactive if no record found
                                                        }
                                                    @endphp
                                                    @if ($status == 'Active')
                                                        <small class='bx bxs-circle me-1 chart-online'></small>Active
                                                        Now
                                                    @else
                                                        <small class='bx bxs-circle me-1 chart-online'
                                                            style="color:orange"></small>Active
                                                        ago
                                                    @endif
                                                </a>
                                                <a href="javascript:;"
                                                    class="list-inline-item d-flex align-items-center text-secondary">|</a>
                                                <a href="javascript:;"
                                                    class="list-inline-item d-flex align-items-center text-secondary">
                                                    <i class='bx bx-search me-1'></i>Find
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-content" id="chat-content-{{ $user->id }}">
                                @foreach ($messages as $message)
                                    @if ($message->from_id == $ID->id)
                                        <div class="chat-content-rightside">
                                            <div class="d-flex ms-auto">
                                                <div class="flex-grow-1 me-2">
                                                    <p class="mb-0 chat-time text-end">You,
                                                        {{ $message->created_at->format('h:i A') }}</p>
                                                    @if (!empty($message->body))
                                                        <p class="chat-right-msg">{!! $message->body !!}</p>
                                                    @endif
                                                    @if (!empty($message->attachment))
                                                        @php
                                                            $fileExtension = pathinfo(
                                                                $message->attachment,
                                                                PATHINFO_EXTENSION,
                                                            );
                                                            $isImage = in_array(strtolower($fileExtension), [
                                                                'jpg',
                                                                'jpeg',
                                                                'png',
                                                                'gif',
                                                                'bmp',
                                                            ]);
                                                        @endphp

                                                        @if ($isImage)
                                                            <div class="chat-attachment">
                                                                <a href="{{ asset($message->attachment) }}"
                                                                    target="_blank">
                                                                    <img src="{{ asset($message->attachment) }}"
                                                                        class="chat-right-msg" alt="Attachment"
                                                                        width="100px" height="100px"
                                                                        style="margin-bottom: 10px">
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="chat-attachment" style="margin-bottom: 10px">
                                                                <a href="{{ asset($message->attachment) }}"
                                                                    class="chat-right-msg" download>
                                                                    <button class="btn btn-sm btn-primary">Download
                                                                        Attachment</button>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="chat-content-leftside">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 ms-2">
                                                    @php
                                                        $single_user = App\adminmodel\Users_detailsModal::where(
                                                            'ajent_id',
                                                            $message->from_id,
                                                        )->first();
                                                        if (!empty($single_user->alise_name)) {
                                                            $single_user_name = $single_user->alise_name;
                                                        } else {
                                                            $single_user_name = $user->name;
                                                        }
                                                    @endphp
                                                    <p class="mb-0 chat-time">{{ $single_user_name }},
                                                        {{ $message->created_at->format('h:i A') }}</p>
                                                    @if (!empty($message->body))
                                                        <p class="chat-left-msg">{{ $message->body }}</p>
                                                    @endif
                                                    @if (!empty($message->attachment))
                                                        @php
                                                            $fileExtension = pathinfo(
                                                                $message->attachment,
                                                                PATHINFO_EXTENSION,
                                                            );
                                                            $isImage = in_array(strtolower($fileExtension), [
                                                                'jpg',
                                                                'jpeg',
                                                                'png',
                                                                'gif',
                                                                'bmp',
                                                            ]);
                                                        @endphp

                                                        @if ($isImage)
                                                            <div class="chat-attachment" style="margin-bottom: 10px">
                                                                <a href="{{ asset($message->attachment) }}"
                                                                    target="_blank">
                                                                    <img src="{{ asset($message->attachment) }}"
                                                                        class="chat-right-msg" alt="Attachment"
                                                                        width="100px" height="100px"
                                                                        style="margin-bottom: 10px">
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="chat-attachment" style="margin-bottom: 10px">
                                                                <a href="{{ asset($message->attachment) }}"
                                                                    class="chat-right-msg" download>
                                                                    <button class="btn btn-sm btn-primary">Download
                                                                        Attachment</button>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="chat-footer d-flex align-items-center">
                                <div class="flex-grow-1 pe-2">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text emoji-button"
                                            data-target="emoji-picker-{{ $user->id }}"><i
                                                class='bx bx-smile'></i></span>
                                        <textarea id="body-{{ $user->id }}" name="body" class="form-control" placeholder="Type a message"
                                            oninput="autoResize(this)" style="height: 10px;" onkeydown="checkEnter(event, '{{ $user->id }}', 'user')"></textarea>

                                    </div>
                                </div>
                                <div class="emoji-picker" id="emoji-picker-{{ $user->id }}">
                                    <div>
                                        <span class="emoji">😀</span> <span class="emoji">😁</span> <span
                                            class="emoji">😂</span> <span class="emoji">🤣</span> <span
                                            class="emoji">😃</span>
                                        <span class="emoji">😄</span> <span class="emoji">😅</span> <span
                                            class="emoji">😆</span> <span class="emoji">😉</span> <span
                                            class="emoji">😊</span>
                                        <span class="emoji">😋</span> <span class="emoji">😎</span> <span
                                            class="emoji">😍</span> <span class="emoji">😘</span> <span
                                            class="emoji">😗</span>
                                        <span class="emoji">😙</span> <span class="emoji">😚</span> <span
                                            class="emoji">🙂</span> <span class="emoji">🤗</span> <span
                                            class="emoji">🤔</span>
                                        <span class="emoji">😐</span> <span class="emoji">😑</span> <span
                                            class="emoji">😶</span> <span class="emoji">🙄</span> <span
                                            class="emoji">😏</span>
                                        <span class="emoji">😣</span> <span class="emoji">😥</span> <span
                                            class="emoji">😮</span> <span class="emoji">🤐</span> <span
                                            class="emoji">😯</span>
                                        <span class="emoji">😪</span> <span class="emoji">😫</span> <span
                                            class="emoji">😴</span> <span class="emoji">😌</span> <span
                                            class="emoji">🤓</span>
                                        <span class="emoji">😛</span> <span class="emoji">😜</span> <span
                                            class="emoji">😝</span> <span class="emoji">🤤</span> <span
                                            class="emoji">😒</span>
                                        <span class="emoji">😓</span> <span class="emoji">😔</span> <span
                                            class="emoji">😕</span> <span class="emoji">🙃</span> <span
                                            class="emoji">🤑</span>
                                        <span class="emoji">😲</span> <span class="emoji">☹️</span> <span
                                            class="emoji">🙁</span> <span class="emoji">😖</span> <span
                                            class="emoji">😞</span>
                                        <span class="emoji">😟</span> <span class="emoji">😤</span> <span
                                            class="emoji">😢</span> <span class="emoji">😭</span> <span
                                            class="emoji">😦</span>
                                        <span class="emoji">😧</span> <span class="emoji">😨</span> <span
                                            class="emoji">😩</span> <span class="emoji">😬</span> <span
                                            class="emoji">😰</span>
                                        <span class="emoji">😱</span> <span class="emoji">😳</span> <span
                                            class="emoji">😵</span> <span class="emoji">😡</span> <span
                                            class="emoji">😠</span>
                                        <span class="emoji">😷</span> <span class="emoji">🤒</span> <span
                                            class="emoji">🤕</span> <span class="emoji">🤢</span> <span
                                            class="emoji">🤧</span>
                                        <span class="emoji">😇</span> <span class="emoji">🤠</span> <span
                                            class="emoji">🤡</span> <span class="emoji">🤥</span> <span
                                            class="emoji">🤫</span>
                                        <span class="emoji">🤭</span> <span class="emoji">🧐</span> <span
                                            class="emoji">🤯</span> <span class="emoji">🤬</span> <span
                                            class="emoji">🤮</span>
                                        <span class="emoji">🤡</span> <span class="emoji">🤠</span> <span
                                            class="emoji">🤑</span> <span class="emoji">🤥</span> <span
                                            class="emoji">🤓</span>
                                        <span class="emoji">👋</span> <span class="emoji">🤚</span> <span
                                            class="emoji">🖐️</span> <span class="emoji">✋</span> <span
                                            class="emoji">👌</span>
                                        <span class="emoji">🤏</span> <span class="emoji">✌️</span> <span
                                            class="emoji">🤞</span> <span class="emoji">🤟</span> <span
                                            class="emoji">🤘</span>
                                        <span class="emoji">🤙</span> <span class="emoji">👈</span> <span
                                            class="emoji">👉</span> <span class="emoji">👆</span> <span
                                            class="emoji">🖕</span>
                                        <span class="emoji">👇</span> <span class="emoji">☝️</span> <span
                                            class="emoji">👍</span> <span class="emoji">👎</span> <span
                                            class="emoji">✊</span>
                                        <span class="emoji">👊</span> <span class="emoji">🤛</span> <span
                                            class="emoji">🤜</span> <span class="emoji">👏</span> <span
                                            class="emoji">🙌</span>
                                        <span class="emoji">👐</span> <span class="emoji">🤲</span> <span
                                            class="emoji">🙏</span>
                                        <!-- Add more emojis as needed -->
                                    </div>
                                </div>
                                <div class="chat-footer-menu">
                                    <input type="file" class="d-none" name="file"
                                        id="fileInput-{{ $user->id }}"
                                        onchange="singlepreviewFile('{{ $user->id }}')">
                                    <a href="javascript:;"
                                        onclick="document.getElementById('fileInput-{{ $user->id }}').click();">
                                        <i class='bx bx-file'></i>
                                    </a>
                                    <a href="javascript:;" class="fadeIn animated bx bx-send"
                                        id="user-sendbutton-{{ $user->id }}"
                                        onclick="submitMessage('{{ $user->id }}')"></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                {{-- =====================================  Group data ============================= --}}
                @if (!empty($filtered_groups))
                    @foreach ($filtered_groups as $group)
                        @php
                            $messages = App\Models\ChMessage::where('group_id', $group->id)
                                ->orderBy('created_at', 'asc')
                                ->get();
                        @endphp
                        <div class="chat-content-container group-chat" id="groupchat-{{ $group->id }}"
                            style="display: none;">
                            {{-- ----------------------------chat header ------------ --}}
                            <div class="chat-header d-flex align-items-center">
                                <div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i></div>
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="chat-user-online">
                                            <a href="javascript:;" class="show-profile-picture">
                                                <img src="{{ asset($group->image) }}" width="45" height="45"
                                                    class="rounded-circle" alt="Profile Picture" />
                                            </a>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <p class="mb-0" data-bs-toggle="modal"
                                                data-bs-target="#edit_group-{{ $group->id }}"
                                                style="font-weight: 500;">{{ $group->name }}
                                            </p>
                                            <div class="list-inline d-sm-flex mb-0">
                                                <a href="javascript:;"
                                                    class="list-inline-item d-flex align-items-center text-secondary search-icon"
                                                    data-group-id="{{ $group->id }}">
                                                    <i class='bx bx-search me-1'></i>Find
                                                </a>
                                                <input type="text" id="search-input-{{ $group->id }}"
                                                    class="form-control search-input"
                                                    data-group-id="{{ $group->id }}" placeholder="Search messages"
                                                    style="display: none; margin-left: 10px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- edit group Modal -->
                            <div class="modal fade" id="edit_group-{{ $group->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Group</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('edit_group') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Group Name</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="text" class="form-control" name="group_name"
                                                            value="{{ $group->name }}" required>
                                                        <input type="hidden" name="group_id"
                                                            value="{{ $group->id }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Profile</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        <input type="file" class="form-control"
                                                            name="group_profile">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-3">Group Members</h6>
                                                    </div>
                                                    <div class="row mb-3">
                                                        @if (!empty($users))
                                                            @foreach ($users as $user)
                                                                <div class="col-sm-6">
                                                                    <div class="input-group-prepend">
                                                                        <input type="checkbox"
                                                                            id="checkbox-{{ $user->id }}"
                                                                            aria-label="Checkbox for following text input"
                                                                            name="agent_ids[]"
                                                                            value="{{ $user->id }}"
                                                                            @php $user_ids_array = json_decode($group->user_ids, true); @endphp
                                                                            @if (in_array($user->id, $user_ids_array)) checked @endif>
                                                                        <label class="form-check-label"
                                                                            for="checkbox-{{ $user->id }}"
                                                                            style="padding:1px">
                                                                            @if ($user->id == $ID->id)
                                                                                You
                                                                            @else
                                                                                {{ $user->name }}
                                                                            @endif
                                                                        </label>
                                                                        {{-- Check if user is admin --}}
                                                                        @if ($user->id == $group->created_by)
                                                                            <span class="badge bg-primary">Admin</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                </div>
                                                <button type="button" class="btn btn-outline-danger px-4"
                                                    onclick="confirmDelete('{{ route('delete_group', $group->id) }}')">
                                                    <i class="fadeIn animated bx bx-trash"></i> Delete
                                                </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Change</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- ----------------------------end chat header ------------ --}}
                            <div class="chat-content" id="groupchat-content-{{ $group->id }}">
                                @foreach ($messages as $message)
                                    <div class="chat-message" id="message-{{ $message->id }}">
                                        <!-- Message content based on the sender -->
                                        @if ($message->from_id == $ID->id)
                                            <div class="chat-content-rightside">
                                                <div class="d-flex ms-auto">
                                                    <div class="flex-grow-1 me-2">
                                                        <p class="mb-0 chat-time text-end">You,
                                                            {{ $message->created_at->format('h:i A') }}</p>
                                                        @if (!empty($message->body))
                                                            <p class="chat-right-msg">
                                                                @if (empty($message->deleted))
                                                                    @if (!empty($message->reply_id))
                                                                        @php
                                                                            $reply = App\Models\ChMessage::where(
                                                                                'id',
                                                                                $message->reply_id,
                                                                            )->first();
                                                                            $reply_message = $reply->body;
                                                                            if (empty($reply_message)) {
                                                                                $reply_message =
                                                                                    '
                                                                                      <img src="' .
                                                                                    asset($reply->attachment) .
                                                                                    '"
                                                                                           alt="Attachment" width="100px"
                                                                                          height="100px" style="margin-bottom: 10px">
                                                                                    ';
                                                                            }
                                                                        @endphp
                                                                        <span class="box-span"
                                                                            data-reply-id="{{ $message->reply_id }}">
                                                                            <i
                                                                                class="lni lni-reply"></i>{!! $reply_message !!}
                                                                        </span><br>
                                                                        {!! $message->body !!}
                                                                    @else
                                                                        {!! $message->body !!}
                                                                    @endif
                                                                @else
                                                                    <i class="fadeIn animated bx bx-block"></i> deleted
                                                            </p>
                                                        @endif

                                                        <div class="dropdown-container">
                                                            <a class="nav-link dropdown-toggle" href="#"
                                                                role="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-more-vertical text-primary"
                                                                    style="margin-top: 10px;">
                                                                    <circle cx="12" cy="12" r="1">
                                                                    </circle>
                                                                    <circle cx="12" cy="5" r="1">
                                                                    </circle>
                                                                    <circle cx="12" cy="19" r="1">
                                                                    </circle>
                                                                </svg>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                data-bs-popper="static">
                                                                <li><a class="dropdown-item" href="#"
                                                                        onclick="copyToClipboard('{{ $message->body }}')">Copy</a>
                                                                </li>
                                                                <li><a class="dropdown-item" href="#"
                                                                        onclick="replyToMessage('{{ $message->body }}', '{{ $message->id }}')">Reply</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('delete_message', $message->id) }}">Delete</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="#"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#forword_group-{{ $message->id }}">
                                                                        Forward
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                        @endif
                                        <!-- Attachment handling -->
                                        @if (!empty($message->attachment))
                                            @php
                                                $fileExtension = pathinfo($message->attachment, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($fileExtension), [
                                                    'jpg',
                                                    'jpeg',
                                                    'png',
                                                    'gif',
                                                    'bmp',
                                                ]);
                                            @endphp
                                            @if (!empty($message->deleted))
                                                <p class="chat-right-msg">
                                                    <i class="fadeIn animated bx bx-block"></i> deleted
                                                </p>
                                            @else
                                                @if ($isImage)
                                                    <div class="chat-attachment" style="margin-bottom: 10px">
                                                        <a href="{{ asset($message->attachment) }}" target="_blank">
                                                            <img src="{{ asset($message->attachment) }}"
                                                                class="chat-right-msg" alt="Attachment"
                                                                width="100px" height="100px"
                                                                style="margin-bottom: 10px">
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="chat-attachment" style="margin-bottom: 10px">
                                                        <a href="{{ asset($message->attachment) }}"
                                                            class="chat-right-msg" download>
                                                            <button class="btn btn-sm btn-primary">Download
                                                                Attachment</button>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                            <div class="dropdown-container">
                                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-more-vertical text-primary"
                                                        style="margin-top: 10px;">
                                                        <circle cx="12" cy="12" r="1">
                                                        </circle>
                                                        <circle cx="12" cy="5" r="1">
                                                        </circle>
                                                        <circle cx="12" cy="19" r="1">
                                                        </circle>
                                                    </svg>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                                                    <li><a class="dropdown-item" href="#"
                                                            onclick="replyToMessage('{{ $message->body }}', '{{ $message->id }}')">Reply</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('delete_message', $message->id) }}">Delete</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#forword_group-{{ $message->id }}">
                                                            Forward
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                            </div>
                        </div>
                    @else
                        <div class="chat-content-leftside">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-2">
                                    @php
                                        $group_user = App\adminmodel\Users_detailsModal::where(
                                            'ajent_id',
                                            $message->from_id,
                                        )->first();
                                    @endphp
                                     <p class="mb-0 chat-time">{{ $group_user->alise_name ?? "Unknown" }},
                                        {{ $message->created_at->format('h:i A') }}</p>
                                    {{-- @if (!empty($message->body))
                                                                    <p class="chat-left-msg">{{ $message->body }}</p>
                                                                @endif --}}
                                    @if (!empty($message->body))
                                        <p class="chat-left-msg" style="float:left">
                                            @if (empty($message->deleted))
                                                @if (!empty($message->reply_id))
                                                    @php
                                                        $reply = App\Models\ChMessage::where(
                                                            'id',
                                                            $message->reply_id,
                                                        )->first();
                                                        $reply_message = $reply->body;
                                                        if (empty($reply_message)) {
                                                            $reply_message =
                                                                '
                                                                                      <img src="' .
                                                                asset($reply->attachment) .
                                                                '"
                                                                                           alt="Attachment" width="100px"
                                                                                          height="100px" style="margin-bottom: 10px">
                                                                                    ';
                                                        }
                                                    @endphp
                                                    <span class="box-span" data-reply-id="{{ $message->reply_id }}">
                                                        <i class="lni lni-reply"></i>{!! $reply_message !!}
                                                    </span><br>
                                                    {!! $message->body !!}
                                                @else
                                                    {!! $message->body !!}
                                                @endif
                                            @else
                                                <i class="fadeIn animated bx bx-block"></i> deleted
                                            @endif
                                        </p>
                                        <div class="dropdown-container" style="float:left">
                                            <a class="nav-link dropdown-toggle" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-more-vertical text-primary"style="margin-top:10px">
                                                    <circle cx="12" cy="12" r="1">
                                                    </circle>
                                                    <circle cx="12" cy="5" r="1">
                                                    </circle>
                                                    <circle cx="12" cy="19" r="1">
                                                    </circle>
                                                </svg>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-start" data-bs-popper="static">
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="copyToClipboard('{{ $message->body }}')">Copy</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="replyToMessage('{{ $message->body }}', '{{ $message->id }}')">Reply</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#forword_group-{{ $message->id }}">
                                                        Forward
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                    <!-- Attachment handling -->
                                    @if (!empty($message->attachment))
                                        @php
                                            $fileExtension = pathinfo($message->attachment, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($fileExtension), [
                                                'jpg',
                                                'jpeg',
                                                'png',
                                                'gif',
                                                'bmp',
                                            ]);
                                        @endphp
                                        @if ($isImage)
                                            <div class="chat-attachment" style="margin-bottom: 10px">
                                                <a href="{{ asset($message->attachment) }}" target="_blank"
                                                    style="float:left">
                                                    <img src="{{ asset($message->attachment) }}"
                                                        class="chat-left-msg" alt="Attachment" width="100px"
                                                        height="100px" style="margin-bottom: 10px">
                                                </a>
                                            </div>
                                        @else
                                            <div class="chat-attachment" style="margin-bottom: 10px">
                                                <a href="{{ asset($message->attachment) }}" class="chat-left-msg"
                                                    style="float:left" download>
                                                    <button class="btn btn-sm btn-primary">Download
                                                        Attachment</button>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="dropdown-container" style="float:left">
                                            <a class="nav-link dropdown-toggle" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-more-vertical text-primary"style="margin-top:10px">
                                                    <circle cx="12" cy="12" r="1">
                                                    </circle>
                                                    <circle cx="12" cy="5" r="1">
                                                    </circle>
                                                    <circle cx="12" cy="19" r="1">
                                                    </circle>
                                                </svg>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-start" data-bs-popper="static">
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="replyToMessage('{{ $message->body }}', '{{ $message->id }}')">Reply</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#forword_group-{{ $message->id }}">
                                                        Forward
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- forword group Modal -->
                    <div class="modal fade" id="forword_group-{{ $message->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Forward Message To
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('forward_message', $message->id) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-3">Groups & Users
                                                </h6>
                                            </div>
                                            <div class="row mb-3">
                                                @if (!empty($filtered_groups))
                                                    <p>Groups</p>
                                                    @foreach ($filtered_groups as $forword_id)
                                                        <div class="col-sm-6">
                                                            <div class="input-group-prepend">
                                                                <input type="checkbox"
                                                                    id="checkbox-{{ $forword_id->id }}"
                                                                    aria-label="Checkbox for following text input"
                                                                    name="group_ids[]"
                                                                    value="{{ $forword_id->id }}">
                                                                <label class="form-check-label"
                                                                    for="checkbox-{{ $forword_id->id }}"
                                                                    style="padding:1px">
                                                                    {{ $forword_id->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                @if (!empty($users))
                                                    <p style="margin: 10px">Users
                                                    </p>
                                                    @foreach ($users as $user)
                                                        <div class="col-sm-6">
                                                            <div class="input-group-prepend">
                                                                <input type="checkbox"
                                                                    id="checkbox-{{ $user->id }}"
                                                                    aria-label="Checkbox for following text input"
                                                                    name="agent_ids[]" value="{{ $user->id }}">
                                                                <label class="form-check-label"
                                                                    for="checkbox-{{ $user->id }}"
                                                                    style="padding:1px">
                                                                    @if ($user->id == $ID->id)
                                                                        You
                                                                    @else
                                                                        {{ $user->name }}
                                                                    @endif
                                                                </label>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Forward</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
            @endforeach
        </div>
        <div class="chat-footer d-flex align-items-center">
            <div class="flex-grow-1 pe-2">

                <div class="input-reply-{{ $group->id }}" style="display: none;">
                    <p style="padding: 10px; background-color:#ddd"><span
                            id="replyText-{{ $group->id }}"></span><span id="reply_id-{{ $group->id }}"
                            style="display:none"></span><i class="fadeIn animated bx bx-x"
                            style="float:right; cursor: pointer;" onclick="hideReplyBox()"></i>
                    </p>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text emoji-button" data-target="emoji-picker-{{ $group->id }}"><i
                            class='bx bx-smile'></i></span>
                    <textarea id="body-group-{{ $group->id }}" name="body" class="form-control" placeholder="Type a message"
                        style="height: 10px;" oninput="autoResize(this)" onkeydown="checkEnter(event, '{{ $group->id }}', 'group')"></textarea>
                </div>
            </div>
            <div class="emoji-picker" id="emoji-picker-{{ $group->id }}">
                <div>
                    <span class="emoji">😀</span> <span class="emoji">😁</span> <span class="emoji">😂</span>
                    <span class="emoji">🤣</span> <span class="emoji">😃</span>
                    <span class="emoji">😄</span> <span class="emoji">😅</span> <span class="emoji">😆</span>
                    <span class="emoji">😉</span> <span class="emoji">😊</span>
                    <span class="emoji">😋</span> <span class="emoji">😎</span> <span class="emoji">😍</span>
                    <span class="emoji">😘</span> <span class="emoji">😗</span>
                    <span class="emoji">😙</span> <span class="emoji">😚</span> <span class="emoji">🙂</span>
                    <span class="emoji">🤗</span> <span class="emoji">🤔</span>
                    <span class="emoji">😐</span> <span class="emoji">😑</span> <span class="emoji">😶</span>
                    <span class="emoji">🙄</span> <span class="emoji">😏</span>
                    <span class="emoji">😣</span> <span class="emoji">😥</span> <span class="emoji">😮</span>
                    <span class="emoji">🤐</span> <span class="emoji">😯</span>
                    <span class="emoji">😪</span> <span class="emoji">😫</span> <span class="emoji">😴</span>
                    <span class="emoji">😌</span> <span class="emoji">🤓</span>
                    <span class="emoji">😛</span> <span class="emoji">😜</span> <span class="emoji">😝</span>
                    <span class="emoji">🤤</span> <span class="emoji">😒</span>
                    <span class="emoji">😓</span> <span class="emoji">😔</span> <span class="emoji">😕</span>
                    <span class="emoji">🙃</span> <span class="emoji">🤑</span>
                    <span class="emoji">😲</span> <span class="emoji">☹️</span> <span class="emoji">🙁</span>
                    <span class="emoji">😖</span> <span class="emoji">😞</span>
                    <span class="emoji">😟</span> <span class="emoji">😤</span> <span class="emoji">😢</span>
                    <span class="emoji">😭</span> <span class="emoji">😦</span>
                    <span class="emoji">😧</span> <span class="emoji">😨</span> <span class="emoji">😩</span>
                    <span class="emoji">😬</span> <span class="emoji">😰</span>
                    <span class="emoji">😱</span> <span class="emoji">😳</span> <span class="emoji">😵</span>
                    <span class="emoji">😡</span> <span class="emoji">😠</span>
                    <span class="emoji">😷</span> <span class="emoji">🤒</span> <span class="emoji">🤕</span>
                    <span class="emoji">🤢</span> <span class="emoji">🤧</span>
                    <span class="emoji">😇</span> <span class="emoji">🤠</span> <span class="emoji">🤡</span>
                    <span class="emoji">🤥</span> <span class="emoji">🤫</span>
                    <span class="emoji">🤭</span> <span class="emoji">🧐</span> <span class="emoji">🤯</span>
                    <span class="emoji">🤬</span> <span class="emoji">🤮</span>
                    <span class="emoji">🤡</span> <span class="emoji">🤠</span> <span class="emoji">🤑</span>
                    <span class="emoji">🤥</span> <span class="emoji">🤓</span>
                    <span class="emoji">👋</span> <span class="emoji">🤚</span> <span class="emoji">🖐️</span>
                    <span class="emoji">✋</span> <span class="emoji">👌</span>
                    <span class="emoji">🤏</span> <span class="emoji">✌️</span> <span class="emoji">🤞</span>
                    <span class="emoji">🤟</span> <span class="emoji">🤘</span>
                    <span class="emoji">🤙</span> <span class="emoji">👈</span> <span class="emoji">👉</span>
                    <span class="emoji">👆</span> <span class="emoji">🖕</span>
                    <span class="emoji">👇</span> <span class="emoji">☝️</span> <span class="emoji">👍</span>
                    <span class="emoji">👎</span> <span class="emoji">✊</span>
                    <span class="emoji">👊</span> <span class="emoji">🤛</span> <span class="emoji">🤜</span>
                    <span class="emoji">👏</span> <span class="emoji">🙌</span>
                    <span class="emoji">👐</span> <span class="emoji">🤲</span> <span class="emoji">🙏</span>
                    <!-- Add more emojis as needed -->
                </div>
            </div>
            <div class="chat-footer-menu">
                <input type="file" class="d-none" name="file" id="fileInput-{{ $group->id }}"
                    onchange="previewFile('{{ $group->id }}')">
                <a href="javascript:;" onclick="document.getElementById('fileInput-{{ $group->id }}').click();">
                    <i class='bx bx-file'></i>
                </a>
                <img id="imagePreview-group-{{ $group->id }}" src="#" alt="Image Preview"
                    style="display:none; width: 100px; height: 100px;">
                <a href="javascript:;" class="fadeIn animated bx bx-send" id="sendButton-{{ $group->id }}"
                    onclick="submitGroupMessage('{{ $group->id }}')"></a>
            </div>
        </div>
    </div>
    @endforeach
    @endif
    </div>
    <!--start chat overlay-->
    <div class="overlay chat-toggle-btn-mobile"></div>
    <audio id="notification-sound" src="{{ asset('Agent/chat-sound.wav') }}" preload="auto"></audio>
    <!--end chat overlay-->
    <!-- Modal -->
    <div class="modal fade" id="create_group" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('create_group') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Group Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control" name="group_name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Profile</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="file" class="form-control" name="group_profile" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-2">Select Users</h6>
                            </div>
                            <div class="row mb-3">
                                @if (!empty($users))
                                    @foreach ($users as $user)
                                        <div class="col-sm-6">
                                            <div class="input-group-prepend">
                                                <input type="checkbox" aria-label="Checkbox for following text input"
                                                    name="agent_ids[]" value="{{ $user->id }}">
                                                <label class="form-check-label" for="checkbox-{{ $user->id }}"
                                                    style="padding:1px">
                                                    @php
                                                        $aliise = App\adminmodel\Users_detailsModal::where(
                                                            'ajent_id',
                                                            $user->id,
                                                        )->first();
                                                        if (!empty($aliise->alise_name)) {
                                                            $edit_alise = $aliise->alise_name;
                                                        } else {
                                                            $edit_alise = $user->name;
                                                        }
                                                    @endphp
                                                    {{ $edit_alise }}</label>
                                            </div>
                                        </div><br><br>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Group</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    </div>
    </div>
    <!--end page wrapper -->
    <!-- Bootstrap JS -->
    <script src="{{ asset('Agent/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('Agent/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('Agent/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('Agent/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('Agent/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('Agent/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('Agent/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('Agent/assets/plugins/chartjs/js/chart.js') }}"></script>
    <script src="{{ asset('Agent/assets/js/index.js') }}"></script>
    <!--app JS-->
    <script src="{{ asset('Agent/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('Agent/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    {{-- notification --}}
    <script src="{{ asset('Agent/assets/plugins/notifications/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('Agent/assets/plugins/notifications/js/notifications.min.js') }}"></script>
    <script src="{{ asset('Agent/assets/plugins/notifications/js/notification-custom-script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to hide all chat content containers
            function hideAllChats() {
                $('.chat-content-container').hide();
            }

            // Function to remove the active class from all user and group items
            function removeActiveClass() {
                $('.user-item, .group-item').removeClass('active');
            }

            // Function to show the chat content container and add the active class
            function showChatContainer(type, id) {
                if (type === 'user') {
                    $('#chat-' + id).show();
                    $('.user-item[data-user-id="' + id + '"]').addClass('active');
                } else if (type === 'group') {
                    $('#groupchat-' + id).show();
                    $('.group-item[data-group-id="' + id + '"]').addClass('active');
                }
            }

            // Check local storage for a saved user ID or group ID
            var activeUserId = localStorage.getItem('activeUserId');
            var activeGroupId = localStorage.getItem('activeGroupId');

            if (activeUserId) {
                showChatContainer('user', activeUserId);
            } else if (activeGroupId) {
                showChatContainer('group', activeGroupId);
            }

            $('.user-item').on('click', function() {
                var userId = $(this).data('user-id');
                //ajax////////////////
                $.ajax({
                    type: 'POST',
                    url: "{{ route('read_mark') }}",
                    data: {
                        user_id: userId
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Handle success response
                        console.log('AJAX request successful:', response);
                        // Optionally update UI or perform additional actions upon success
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error('AJAX request failed:', error);
                        // Optionally show an error message or perform other error handling
                    }
                });

                // Save the selected user ID to local storage
                localStorage.setItem('activeUserId', userId);
                localStorage.removeItem('activeGroupId');

                // Remove active class from all user and group items
                removeActiveClass();

                // Hide all chat content containers
                hideAllChats();

                // Show the selected user's chat content container
                showChatContainer('user', userId);
            });

            $('.group-item').on('click', function() {
                var groupId = $(this).data('group-id');
                //ajax////////////////
                $.ajax({
                    type: 'POST',
                    url: "{{ route('read_mark') }}",
                    data: {
                        group_id: groupId
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Handle success response
                        console.log('AJAX request successful:', response);
                        // Optionally update UI or perform additional actions upon success
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error('AJAX request failed:', error);
                        // Optionally show an error message or perform other error handling
                    }
                });
                // Save the selected group ID to local storage
                localStorage.setItem('activeGroupId', groupId);
                localStorage.removeItem('activeUserId');

                // Remove active class from all user and group items
                removeActiveClass();

                // Hide all chat content containers
                hideAllChats();

                // Show the selected group's chat content container
                showChatContainer('group', groupId);

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.bx-send').on('click', function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = new FormData();
                var activeUserId = $('.user-item.active').data('user-id');
                var activeGroupId = $('.group-item.active').data('group-id');
                var toId = activeUserId ? activeUserId : null;
                var groupId = activeGroupId ? activeGroupId : null;
                var id = toId ? toId : groupId;
                var fileInput = $('#fileInput-' + (toId ? toId : groupId))[0].files[0];
                var messageBody = $('#body-' + id).val();
                var groupBody = $('#body-group-' + id).val();
                var replyid = $('#reply_id-' + groupId).text().trim();

                console.log('Click Message Body:', groupBody);

                // Append message body
                if (messageBody) {
                    formData.append('body', messageBody);
                }
                if (groupBody) {
                    formData.append('groupbody', groupBody);
                }

                // Append file if selected
                if (fileInput) {
                    formData.append('file', fileInput);
                }

                // Append recipient or group ID
                if (toId) {
                    formData.append('to_id', toId);
                }
                if (replyid) {
                    formData.append('replyId', replyid);
                }
                if (groupId) {
                    formData.append('group_id', groupId);
                }

                // AJAX request
                $.ajax({
                    url: "{{ route('admin_send.message') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Clear input fields after successful submission
                            $('#body-' + (toId ? toId : groupId)).val('');
                            $('#fileInput-' + (toId ? toId : groupId)).val('');
                            $('#body-group-' + id).val('');

                            // Example: Append new message to the chat (customize as per your chat UI)
                            var newMessage = '';
                            if (messageBody) {
                                newMessage +=
                                    '<div class="chat-content-rightside"><div class="d-flex ms-auto"><div class="flex-grow-1 me-2"><p class="mb-0 chat-time text-end">You, just now</p><p class="chat-right-msg">' +
                                    messageBody + '</p></div></div></div>';
                            }
                            if (groupBody) {
                                if (response.reply) {
                                    hideReplyBox();
                                    newMessage +=
                                        '<div class="chat-content-rightside"><div class="d-flex ms-auto"><div class="flex-grow-1 me-2"><p class="mb-0 chat-time text-end">You, just now</p><p class="chat-right-msg"><span class="box-span" data-reply-id="' +
                                        replyid + '"><i class="lni lni-reply"></i>' +
                                        response.reply + '</span><br>' +
                                        groupBody + '</p></div></div></div>';
                                } else {
                                    newMessage +=
                                        '<div class="chat-content-rightside"><div class="d-flex ms-auto"><div class="flex-grow-1 me-2"><p class="mb-0 chat-time text-end">You, just now</p><p class="chat-right-msg">' +
                                        groupBody + '</p></div></div></div>';
                                }
                            }

                            // Append file if selected
                            if (fileInput) {
                                var fileExtension = fileInput.name.split('.').pop()
                                    .toLowerCase();
                                var imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                                if (imageExtensions.indexOf(fileExtension) !== -1) {
                                    newMessage +=
                                        '<div class="chat-content-rightside"><div class="d-flex ms-auto"><div class="flex-grow-1 me-2"><p class="mb-0 chat-time text-end">You, just now</p><img src="' +
                                        URL.createObjectURL(fileInput) +
                                        '" class="chat-right-msg" alt="Attachment" width="100px" height="100px"></div></div></div>';
                                } else {
                                    newMessage +=
                                        '<div class="chat-content-rightside"><div class="d-flex ms-auto"><div class="flex-grow-1 me-2"><p class="mb-0 chat-time text-end">You, just now</p><a href="' +
                                        URL.createObjectURL(fileInput) +
                                        '" class="chat-right-msg" download><button class="btn btn-sm btn-primary">Download Attachment</button></a></div></div></div>';
                                }
                            }

                            $('#chat-content-' + (toId ? toId : groupId)).append(newMessage);
                            $('#groupchat-content-' + (toId ? toId : groupId)).append(
                                newMessage);

                            // Optionally, scroll to the bottom of the chat window after adding a new message
                            var chatContent = $('#chat-content-' + (toId ? toId : groupId));
                            chatContent.scrollTop(chatContent.prop("scrollHeight"));

                            var groupchatContent = $('#groupchat-content-' + (toId ? toId :
                                groupId));
                            groupchatContent.scrollTop(groupchatContent.prop("scrollHeight"));
                        } else {
                            alert('Failed to send message');
                        }
                    },
                    error: function() {
                        alert('An error occurred');
                    }
                });
            });

            var channel = pusher.subscribe('my-chat-channel');
            channel.bind('my-chat-event', function(data) {
                var message = data.message.body;
                var fromId = data.message.from_id;
                var groupId = data.message.group_id;
                var userName = data.message.from_name;
                var timestamp = new Date(data.message.created_at).toLocaleTimeString();
                var attachment = data.message.attachment;
                var reply_message = data.message.reply_message;
                var reply_id = data.message.reply_id;
                var file_image = "{{ asset('') }}" + attachment;
                var isImage = false;
                var isOwnMessage = (fromId == '{{ $ID->id }}');
                // Check if there's an attachment and determine if it's an image
                if (attachment && attachment.trim() !== '') {
                    var fileExtension = attachment.split('.').pop().toLowerCase();
                    var imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

                    if (imageExtensions.indexOf(fileExtension) !== -1) {
                        isImage = true;
                    }
                }

                // Construct the message HTML based on type (text or image)

                var newMessage = '';
                if (!message) {
                    if (isImage) {
                        newMessage = '<div class="chat-content-leftside">' +
                            '<div class="d-flex ms-auto">' +
                            '<div class="flex-grow-1 me-2">' +
                            '<p class="mb-0 chat-time">' + userName + ', ' + timestamp + '</p>' +
                            '<img src="{{ asset('') }}' + attachment +
                            '" style="width:100px;height:100px;" class="chat-left-msg" alt="Attachment">' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    } else {
                        newMessage = '<div class="chat-content-leftside">' +
                            '<div class="d-flex">' +
                            '<div class="flex-grow-1 ms-2">' +
                            '<p class="mb-0 chat-time">' + userName + ', ' + timestamp + '</p>' +
                            '<a href="{{ asset('') }}' + attachment +
                            '" class="btn btn-sm btn-primary" download>Download Attachment</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                } else {
                    if (reply_message) {
                        newMessage = '<div class="chat-content-leftside">' +
                            '<div class="d-flex">' +
                            '<div class="flex-grow-1 ms-2">' +
                            '<p class="mb-0 chat-time">' + userName + ', ' + timestamp + '</p>' +
                            '<p class="chat-left-msg"><span class="box-span" data-reply-id="' + reply_id +
                            '">' +
                            '<i class="lni lni-reply"></i>' + reply_message + '</span><br>' + message +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    } else {
                        newMessage = '<div class="chat-content-leftside">' +
                            '<div class="d-flex">' +
                            '<div class="flex-grow-1 ms-2">' +
                            '<p class="mb-0 chat-time">' + userName + ', ' + timestamp + '</p>' +
                            '<p class="chat-left-msg">' + message + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                    }
                }


                // Append the message to the chat content
                if (!isOwnMessage) {
                    if (fromId) {
                        $('#chat-content-' + fromId).append(newMessage);
                    }
                }
                if (groupId) {
                    if (!isOwnMessage) {
                        $('#groupchat-content-' + groupId).append(newMessage);
                        var groupchatContent = $('#groupchat-content-' + groupId);
                        groupchatContent.scrollTop(groupchatContent.prop("scrollHeight"));
                    }
                }

                var notificationSound = document.getElementById('notification-sound');
                notificationSound.play();

                // Scroll to the bottom of the chat window after adding a new message
                var chatContent = $('#chat-content-' + (fromId ? fromId : groupId));
                chatContent.scrollTop(chatContent.prop("scrollHeight"));
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var initialLoad = true;

            function scrollToBottom(chatContentId) {
                var chatContent = document.getElementById(chatContentId);
                if (chatContent) {
                    chatContent.scrollTop = chatContent.scrollHeight;
                }
            }

            // Scroll to the bottom of the initially visible chat content
            @if (!empty($users))
                @foreach ($users as $user)
                    setTimeout(function() {
                        if (initialLoad) {
                            scrollToBottom('chat-content-{{ $user->id }}');
                        }
                    }, 100); // Adjust the delay as needed
                @endforeach
            @endif

            @if (!empty($filtered_groups))
                @foreach ($filtered_groups as $group)
                    setTimeout(function() {
                        if (initialLoad) {
                            scrollToBottom('groupchat-content-{{ $group->id }}');
                        }
                    }, 100); // Adjust the delay as needed
                @endforeach
            @endif

            // Once the initial load is complete, set initialLoad to false
            setTimeout(function() {
                initialLoad = false;
            }, 200); // Adjust the delay as needed to ensure initial load completes

            function handleNewMessage(chatContentId) {
                var chatContent = document.getElementById(chatContentId);
                if (chatContent) {
                    var isScrolledToBottom = chatContent.scrollHeight - chatContent.clientHeight <= chatContent
                        .scrollTop + 1;
                    if (!isScrolledToBottom) {
                        // Don't scroll to bottom if not already at the bottom
                        return;
                    }
                    chatContent.scrollTop = chatContent.scrollHeight;
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.show-profile-picture').click(function() {
                var imageUrl = $(this).find('img').attr('src');

                // Show overlay
                $('.overlay').html('<img src="' + imageUrl +
                    '" class="rounded-circle" alt="Profile Picture">');
                $('.overlay').fadeIn();

                // Close overlay on click outside the image
                $('.overlay').click(function() {
                    $(this).fadeOut();
                });

                return false; // Prevent default action of anchor tag
            });
        });
    </script>
    <script>
        function confirmDelete(url) {
            if (confirm('Are you sure you want to delete this group?')) {
                window.location.href = url;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            // Toggle the emoji picker
            $('.emoji-button').on('click', function() {
                var target = $(this).data('target');
                $('#' + target).toggle();
            });

            // Insert emoji into the textarea
            $('.emoji-picker .emoji').on('click', function() {
                var emoji = $(this).text();
                var targetId = $(this).closest('.emoji-picker').attr('id').replace('emoji-picker-', '');
                var textarea = $('#body-' + targetId);
                if (textarea.length ===
                    0) { // If individual message textarea not found, check for group message textarea
                    textarea = $('#body-group-' + targetId);
                }
                var cursorPos = textarea.prop('selectionStart');
                var text = textarea.val();
                var before = text.substring(0, cursorPos);
                var after = text.substring(cursorPos, text.length);
                textarea.val(before + emoji + after);
                textarea.focus();
                $(this).closest('.emoji-picker').hide();
            });

            // Function to auto-resize the textarea
            window.autoResize = function(element) {
                element.style.height = 'auto';
                element.style.height = (element.scrollHeight) + 'px';
            };
        });
    </script>
    <script>
        $(document).ready(function() {
            // Show search input on search icon click
            $(document).on('click', '.search-icon', function() {
                var groupId = $(this).data('group-id');
                $('#search-input-' + groupId).toggle();
                $('#search-input-' + groupId).focus();
            });

            // Handle search input
            $(document).on('input', '.search-input', function() {
                // Handle search input
                var searchTerm = $(this).val().trim().toLowerCase();
                var selectedGroupId = $('.group-item.active').data('group-id');

                // Remove previous highlighting
                $('#groupchat-content-' + selectedGroupId + ' .chat-message').removeClass('highlighted');

                // Only proceed if there is a search term
                if (searchTerm.length > 0) {
                    // Find and highlight messages based on search term
                    var firstHighlightedMessage = null;
                    $('#groupchat-content-' + selectedGroupId + ' .chat-message').each(function() {
                        var messageText = $(this).find('.chat-left-msg, .chat-right-msg').text()
                            .toLowerCase();
                        if (messageText.includes(searchTerm)) {
                            $(this).addClass('highlighted');
                            if (!firstHighlightedMessage) {
                                firstHighlightedMessage = $(this);
                            }
                        }
                    });

                    // Scroll to the first highlighted message
                    if (firstHighlightedMessage) {
                        var chatContent = $('#groupchat-content-' + selectedGroupId);
                        var scrollTo = firstHighlightedMessage.offset().top - chatContent.offset().top +
                            chatContent.scrollTop();
                        chatContent.animate({
                            scrollTop: scrollTo
                        }, 500);
                    }
                }

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle input in search box
            $('#search-input').on('input', function() {
                var searchText = $(this).val().toLowerCase();

                $('#chat-list .list-group-item').each(function() {
                    var itemText = $(this).text().toLowerCase();

                    // Show or hide based on search text
                    if (itemText.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // Update scrollbar position
                updateScrollbar();
            });

            // Function to update scrollbar position
            function updateScrollbar() {
                var selectedMessage = $('#chat-list .list-group-item:visible').first();
                if (selectedMessage.length > 0) {
                    $('#chat-list').scrollTop(selectedMessage.offset().top - $('#chat-list').offset().top + $(
                        '#chat-list').scrollTop());
                }
            }
        });
    </script>
    <script>
        function copyToClipboard(message) {
            navigator.clipboard.writeText(message).then(function() {
                console.log('Message copied to clipboard');
            }).catch(function(err) {
                console.error('Failed to copy text: ', err);
            });
        }
    </script>
    <script>
        function copyToClipboard(message) {
            navigator.clipboard.writeText(message).then(function() {
                console.log('Message copied to clipboard');
            }).catch(function(err) {
                console.error('Failed to copy text: ', err);
            });
        }

        function replyToMessage(message, id) {
            // Set the message body in the reply box
            var activeGroupId = $('.group-item.active').data('group-id');
            document.getElementById('replyText-' + activeGroupId).textContent = 'Replying to: ' + message;
            document.getElementById('reply_id-' + activeGroupId).textContent = id;
            // Show the reply box
            document.querySelector('.input-reply-' + activeGroupId).style.display = 'block';
        }

        function hideReplyBox() {
            // Hide the reply box
            var activeGroupId = $('.group-item.active').data('group-id');
            document.querySelector('.input-reply-' + activeGroupId).style.display = 'none';
            $('#replyText-' + activeGroupId).text(''); // Clearing the reply text
            $('#reply_id-' + activeGroupId).text('');
        }
    </script>
    <script>
        $(document).ready(function() {
            // Add click event listener to reply messages
            $(document).on('click', '.box-span', function() {
                var replyId = $(this).data('reply-id'); // Get the reply message ID
                var targetMessage = $('#message-' + replyId); // Find the target message by ID

                if (targetMessage.length) {
                    var chatContent = $(this).closest(
                        '.chat-content'); // Find the closest chat content container
                    var messagePosition = targetMessage.position()
                        .top; // Get the position of the target message relative to the chat content container

                    chatContent.animate({
                        scrollTop: chatContent.scrollTop() + messagePosition -
                            100 // Adjust the scrollTop with an offset of 100 pixels
                    }, 500, function() {
                        // Add the highlight class
                        targetMessage.addClass('highlight');

                        // Remove the highlight class after a delay
                        setTimeout(function() {
                            targetMessage.removeClass('highlight');
                        }, 2000);
                    }); // Scroll to the target message with animation
                }
            });
        });
    </script>
    <script>
        function autoResize(element) {
            element.style.height = 'auto';
            element.style.height = element.scrollHeight + 'px';
        }

        function submitMessage(userId) {
            const textarea = document.getElementById('body-' + userId);
            // Handle form submission logic here, for example, using AJAX
            // After submission, reset the textarea height
            textarea.style.height = '10px';
            console.log(`Message submitted for user: ${userId}`); // For debugging

            var existingPreview = document.querySelector('.file-preview-' + userId);
            if (existingPreview) {
                existingPreview.remove();
            }
        }

        function submitGroupMessage(groupId) {
            const input = document.getElementById('body-group-' + groupId);
            // Handle form submission logic here, for example, using AJAX
            // After submission, reset the input height
            textarea.style.height = '10px';
            console.log(`Message submitted for group: ${groupId}`); // For debugging

            var existingPreview = document.querySelector('.file-preview-' + groupId);
            if (existingPreview) {
                existingPreview.remove();
            }
        }

        function checkEnter(event, id, type) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                if (type === 'user') {
                    submitMessage(id);
                } else if (type === 'group') {
                    submitGroupMessage(id);
                }
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            var textareas = document.querySelectorAll('textarea[id^="body-group-"]');
            var textareasuser = document.querySelectorAll('textarea[id^="body-"]');
            var sendButtons = document.querySelectorAll('a[id^="sendButton-"]');

            textareas.forEach(function(textarea) {
                textarea.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter' && !event.shiftKey) {
                        event.preventDefault(); // Prevent the default newline behavior
                        var groupId = textarea.id.split('body-group-')[1];
                        var sendButton = document.getElementById('sendButton-' + groupId);
                        sendButton.click(); // Trigger the send button click
                    }
                });
            });
            textareasuser.forEach(function(textareaa) {
                textareaa.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter' && !event.shiftKey) {
                        event.preventDefault(); // Prevent the default newline behavior
                        var userid = textareaa.id.split('body-')[1];
                        var sendButton = document.getElementById('user-sendbutton-' + userid);
                        sendButton.click(); // Trigger the send button click
                    }
                });
            });
        });
    </script>
    <script>
        function previewFile(groupId) {
            var fileInput = document.getElementById('fileInput-' + groupId);
            var file = fileInput.files[0];
            var sendButton = document.getElementById('sendButton-' + groupId);

            if (file) {
                var fileName = file.name;
                var reader = new FileReader();

                reader.onloadend = function() {
                    var preview = document.createElement('img');
                    preview.style.width = '100px'; // Adjust width as needed
                    preview.style.height = '100px'; // Adjust height as needed
                    preview.src = reader.result;
                    preview.alt = fileName;
                    preview.classList.add('file-preview-' + groupId);

                    // Clear previous previews
                    var existingPreview = document.querySelector('.file-preview-' + groupId);
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    // Append preview to the DOM
                    sendButton.insertAdjacentElement('beforebegin', preview);

                    // Add click event listener to remove the preview
                    preview.addEventListener('click', function() {
                        preview.remove();
                        fileInput.value = ''; // Clear the file input
                    });
                };

                reader.readAsDataURL(file);
            }
        }
    </script>
    <script>
        function singlepreviewFile(userid) {
            var fileInput = document.getElementById('fileInput-' + userid);
            var file = fileInput.files[0];
            var sendButton = document.getElementById('user-sendbutton-' + userid);

            if (file) {
                var fileName = file.name;
                var reader = new FileReader();

                reader.onloadend = function() {
                    var preview = document.createElement('img');
                    preview.style.width = '100px'; // Adjust width as needed
                    preview.style.height = '100px'; // Adjust height as needed
                    preview.src = reader.result;
                    preview.alt = fileName;
                    preview.classList.add('file-preview-' + userid);

                    // Clear previous previews
                    var existingPreview = document.querySelector('.file-preview-' + userid);
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    // Append preview to the DOM
                    sendButton.insertAdjacentElement('beforebegin', preview);

                    // Add click event listener to remove the preview
                    preview.addEventListener('click', function() {
                        preview.remove();
                        fileInput.value = ''; // Clear the file input
                    });
                };

                reader.readAsDataURL(file);
            }
        }
    </script>

    </body>

</html>
