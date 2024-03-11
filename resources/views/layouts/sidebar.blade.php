<!-- resources/views/components/sidebar.blade.php -->

<div class="sidebar">
    @auth
        @if(auth()->user()->isAdmin())
            <h3>Admin Panel</h3>
            <ul>
                <li><a href="{{ route('home') }}">Dashboard</a></li>
                <li><a href="#">Manage Users</a></li>
                <!-- Add more admin-specific links as needed -->
            </ul>
        @else
            <h3>User Panel</h3>
            <ul>
                <li><a href="{{ route('home') }}">Dashboard</a></li>
                <!-- Add more user-specific links as needed -->
            </ul>
        @endif
    @endauth

    <h3>General</h3>
    <ul>
        <li><a href="{{ route('user-list') }}">User List</a></li>
        <li><a href="{{ route('customer-list') }}">Customer List</a></li>
        <!-- Add more sidebar items as needed -->
    </ul>
</div>
