<div>

    @if (session()->has('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <select wire:model.live="statusFilter" class="form-select mb-3">
        <option value="all">All</option>
        <option value="pending">Pending</option>
        <option value="accepted">Accepted</option>
        <option value="rejected">Rejected</option>
    </select>

    @forelse($orders as $merchantOrder)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Order #{{ $merchantOrder->order->id }}</h5>

                <p>
                    Client: {{ $merchantOrder->order->client->name }} <br>
                </p>

                <p>
                    Addresse:
                    {{ $merchantOrder->order->addresse->title }} - {{ $merchantOrder->order->addresse->street }}
                    {{ $merchantOrder->order->addresse->city }} - {{ $merchantOrder->order->addresse->state }}
                    {{ $merchantOrder->order->addresse->postal_code }} - {{ $merchantOrder->order->addresse->country }}
                    {{ $merchantOrder->order->addresse->phone }}
                </p>

                <p>
                    Status:
                    <strong>{{ ucfirst($merchantOrder->status) }}</strong>
                </p>

                <ul>
                    @foreach($merchantOrder->order->items as $item)
                        <li>
                            {{ $item->product->name ?? 'Product' }}
                            × {{ $item->qty }}
                            — {{ $item->price }} MAD
                        </li>
                    @endforeach
                </ul>

                @if($merchantOrder->status === 'pending')
                    <button wire:click="accept({{ $merchantOrder->id }})"
                            class="btn btn-success btn-sm">
                        Accept
                    </button>

                    <button wire:click="reject({{ $merchantOrder->id }})"
                            class="btn btn-danger btn-sm">
                        Reject
                    </button>
                @endif
            </div>
        </div>
    @empty
        <p>No orders yet.</p>
    @endforelse
</div>

