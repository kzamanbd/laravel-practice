<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="https://sandbox.payhere.lk/pay/checkout" class="grid grid-cols-3 gap-4">
                        <input type="hidden" class="form-control" name="merchant_id" value="{{ $data['merchant_id'] }}">
                        <input type="hidden" class="form-control" name="return_url" value="{{ $data['return_url'] }}">
                        <input type="hidden" class="form-control" name="cancel_url" value="{{ $data['cancel_url'] }}">
                        <input type="hidden" class="form-control" name="notify_url" value="{{ $data['notify_url'] }}">
                        <div class="col-span-3">
                            Items
                        </div>
                        <input type="text" class="form-control" name="order_id" value="{{ $data['order_id'] }}">
                        <input type="text" class="form-control" name="items" value="Door bell wireless">
                        <input type="text" class="form-control" name="currency" value="{{ $data['currency'] }}">
                        <input type="text" class="form-control" name="amount" value="{{ $data['amount'] }}">
                        <div class="col-span-3">
                            Customer Details
                        </div>
                        <input type="text" class="form-control" name="first_name" value="Saman">
                        <input type="text" class="form-control" name="last_name" value="Perera">
                        <input type="text" class="form-control" name="email" value="samanp@gmail.com">
                        <input type="text" class="form-control" name="phone" value="0771234567">
                        <input type="text" class="form-control" name="address" value="No.1, Galle Road">
                        <input type="text" class="form-control" name="city" value="Colombo">
                        <input type="text" class="form-control" name="country" value="Sri Lanka">
                        <input type="text" class="form-control" name="delivery_address" value="No. 46, Galle road">
                        <input type="text" class="form-control" name="delivery_city" value="Kandy">
                        <input type="text" class="form-control" name="delivery_country" value="Sri Lanka">

                        <input type="hidden" name="hash" value="{{ $data['hash'] }}">
                        <!-- Replace with generated hash -->
                        <x-primary-button type="submit">
                            Pay Now
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
