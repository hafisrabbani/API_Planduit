<?php

namespace App\Services\Calculator\ProfileResiko;

use LaravelEasyRepository\Service;
use App\DTO\ProfileResikoDTO;
class ProfileResikoServiceImplement extends Service implements ProfileResikoService{
    private ProfileResikoDTO $data;
    public $results = [];
    public function setData(ProfileResikoDTO $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getResults(): array
    {
        $this->calculateScore();
        return $this->results;
    }

    private function calculateScore(){
        $score = $this->reduce($this->data->answers, function($accumulator, $currentValue, $index){
            return $accumulator + $currentValue;
        }, 7);
        $finalScore = $this->finalScore($score);

        if($finalScore >= 0.75) {
            $this->results['information'] = "Investor tipe Agresif. Meningkatakan peluang dengan memaksimalkan pertumbuhan modal. Investor tidak ragu untuk mengalokasikan uang dalam jumlah tertentu ke jenis investasi berisiko tinggi.";
            $this->results['type'] = "Agresif";
            $this->results['time_period'] = "(Long Term) Jangka waktu investasi minimal 5 tahun";
            $this->results['instrument'] = "Saham, Reksadana Saham, Crypto, Forex";
            $this->results['risk'] = "Tinggi";
        }elseif ($finalScore >= 0.3) {
            $this->results['information'] = "Investor tipe Moderat. Menyeimbangkan antara risiko dengan imbal hasil agar mencapai keuntungan yang optimal secara berkala namun tetap berhati-hati saat menentukan instrumen investasinya";
            $this->results['type'] = "Moderat";
            $this->results['time_period'] = "(Medium Term) Jangka waktu investasi minimal 3-5 tahun";
            $this->results['instrument'] = "Reksadana Pendapatan Tetap, Obligasi, Saham Bluechip";
            $this->results['risk'] = "Sedang";
        }elseif ($finalScore >= 0) {
            $this->results['information'] = "Investor tipe Konservatif. Mencari modal, menghondari risiko tinggi, dan menyukai produk demham nilai stabil dengan memberikan pengembalian yang lebih rendah.";
            $this->results['type'] = "Konservatif";
            $this->results['time_period'] = "(Short Term) Jangka waktu investasi minimal Kurang dari 1 Tahun";
            $this->results['instrument'] = "Emas, Reksadana Pasar Uang, Deposito";
            $this->results['risk'] = "Rendah";
        }else {
            $this->results = [];
        }
    }

    private function reduce($array, $callback, $initial = null) {
        $accumulator = $initial;

        foreach ($array as $index => $currentValue) {
            $accumulator = $callback($accumulator, $currentValue, $index);
        }

        return $accumulator;
    }

    private function finalScore($score):float{
        return $score/28;
    }
}
