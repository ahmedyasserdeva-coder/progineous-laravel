@extends('frontend.layout')

@section('title', 'Add Test Item to Cart')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Add Test Item to Cart</h2>
        
        <form action="{{ route('cart.add-test-item') }}" method="POST">
            @csrf
            <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all">
                Add Test Item & Go to Checkout
            </button>
        </form>
    </div>
</div>
@endsection
