<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quote\StoreQuoteRequest;
use App\Http\Requests\Quote\UpdateQuoteRequest;
use App\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        return view('admin.quotes.index');
    }

    public function indexData(Request $request)
    {
        $quotes = Quote::where('description', 'LIKE', '%'.$request->get('searchKeyword').'%');

        return response()->custom(200, "Quotes!", $quotes->orderBy('id', 'desc')->paginate(12));
    }

    public function store(StoreQuoteRequest $request)
    {
        $quote = new Quote;
        $quote->fill($request->all());

        if ($quote->save()) {
            return response()->custom(200, "Quote saved!", $quote);
        }

        return response()->custom(400, "Quote not saved!", $quote);
    }

    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        $quote->fill($request->all());

        if ($quote->update()) {
            return response()->custom(200, "Quote updated!", $quote);
        }

        return response()->custom(400, "Quote not updated!", $quote);
    }

    public function destroy(Quote $quote)
    {
        try {
            $quote->delete();

            return response()->custom(200, "Quote deleted!", null);
        } catch (\Exception $e) {

            return response()->custom(400, "Quote not deleted!", null);
        }
    }
}
