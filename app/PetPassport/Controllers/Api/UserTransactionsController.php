<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\UserTransaction;
use App\PetPassport\Models\Announcement\Announcement;

class UserTransactionsController extends Controller
{
    /**
     * @return array
     */
    public function index()
    {
        $transactions = UserTransaction::orderBy('id', 'desc')->get();
        return [
            'transactions' => $transactions
        ];
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $opcode = $request->opcode ? $request->opcode : 1;
        $amount = $request->amount;
        if ($opcode == 201 || $opcode == 202) {
            $prices = [
                7 => 1000,
                14 => 2000,
                28 => 4000
            ];
            $amount = -$prices[$request->days];
        }
        if ($opcode == 203) {
            $amount = -500;
        }
        if ($request->paytype == 1 && $user->balance < abs($amount)) {
            $diff = abs($amount) - $user->balance;
            $transaction = new UserTransaction;
            $transaction->user_id = $user->id;
            $transaction->opcode = 1;
            $transaction->amount = $diff;
            $transaction->currency = $user->currency;
            $transaction->save();
            $user->increment('balance', $diff);
        }
        if ($request->paytype == 2) {
            $transaction = new UserTransaction;
            $transaction->user_id = $user->id;
            $transaction->opcode = 1;
            $transaction->amount = abs($amount);
            $transaction->currency = $user->currency;
            $transaction->save();
            $user->increment('balance', abs($amount));
        }
        $transaction = new UserTransaction;
        $transaction->user_id = $user->id;
        $transaction->opcode = $opcode;
        $transaction->amount = $amount;
        $transaction->currency = $user->currency;
        if ($opcode == 201 || $opcode == 202 || $opcode == 203) {
            $transaction->data = [
                'announcement_id' => $request->announcement_id
            ];
        }
        $transaction->save();
        if ($transaction->amount > 0) {
            $user->increment('balance', $transaction->amount);
        } else {
            $user->decrement('balance', abs($transaction->amount));
        }
        if ($opcode == 201) {
            $announcement = Announcement::find($request->announcement_id);
            if (!$announcement->colored) {
                $announcement->colored_until = now();
            }
            $announcement->colored_until = $announcement->colored_until->addDays($request->days);
            $announcement->save();
        }
        if ($opcode == 202) {
            $announcement = Announcement::find($request->announcement_id);
            if (!$announcement->pinned) {
                $announcement->pinned_until = now();
            }
            $announcement->pinned_until = $announcement->pinned_until->addDays($request->days);
            $announcement->created_at = now();
            $announcement->save();
        }
        if ($opcode == 203) {
            $announcement = Announcement::find($request->announcement_id);
            $announcement->created_at = now();
            $announcement->save();
        }
        return $user;
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }
}
