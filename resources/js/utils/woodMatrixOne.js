const woodMatrix = [
    {
        height: 0.80,
        width: 0.60,
        price: 1941,
    },
    {
        height: 0.80,
        width: 0.70,
        price: 2182,
    },
    {
        height: 0.80,
        width: 0.80,
        price: 2374,
    },
    {
        height: 0.80,
        width: 0.90,
        price: 2597,
    },
    {
        height: 0.80,
        width: 1.05,
        price: 3314,
    },
    {
        height: 0.80,
        width: 1.20,
        price: 3638,
    },
    {
        height: 0.80,
        width: 1.35,
        price: 4005,
    },
    {
        height: 0.80,
        width: 1.50,
        price: 4326,
    },
    {
        height: 0.80,
        width: 1.80,
        price: 5114,
    },
    {
        height: 0.80,
        width: 2.10,
        price: 5797,
    },
    {
        height: 0.80,
        width: 2.40,
        price: 6448,
    },
    {
        height: 1.00,
        width: 0.60,
        price: 2130,
    },
    {
        height: 1.00,
        width: 0.70,
        price: 2418,
    },
    {
        height: 1.00,
        width: 0.80,
        price: 2637,
    },
    {
        height: 1.00,
        width: 0.90,
        price: 2893,
    },
    {
        height: 1.00,
        width: 1.05,
        price: 3712,
    },
    {
        height: 1.00,
        width: 1.20,
        price: 4087,
    },
    {
        height: 1.00,
        width: 1.35,
        price: 4502,
    },
    {
        height: 1.00,
        width: 1.50,
        price: 4880,
    },
    {
        height: 1.00,
        width: 1.80,
        price: 5797,
    },
    {
        height: 1.00,
        width: 2.10,
        price: 6593,
    },
    {
        height: 1.00,
        width: 2.40,
        price: 7342,
    },
    {
        height: 1.20,
        width: 0.60,
        price: 2284,
    },
    {
        height: 1.20,
        width: 0.70,
        price: 2603,
    },
    {
        height: 1.20,
        width: 0.80,
        price: 2849,
    },
    {
        height: 1.20,
        width: 0.90,
        price: 3134,
    },
    {
        height: 1.20,
        width: 1.05,
        price: 4031,
    },
    {
        height: 1.20,
        width: 1.20,
        price: 4446,
    },
    {
        height: 1.20,
        width: 1.35,
        price: 4913,
    },
    {
        height: 1.20,
        width: 1.50,
        price: 5323,
    },
    {
        height: 1.20,
        width: 1.80,
        price: 6838,
    },
    {
        height: 1.20,
        width: 2.10,
        price: 7786,
    },
    {
        height: 1.20,
        width: 2.40,
        price: 8681,
    },
    {
        height: 1.40,
        width: 0.60,
        price: 2483,
    },
    {
        height: 1.40,
        width: 0.70,
        price: 2851,
    },
    {
        height: 1.40,
        width: 0.80,
        price: 3121,
    },
    {
        height: 1.40,
        width: 0.90,
        price: 3705,
    },
    {
        height: 1.40,
        width: 1.05,
        price: 4785,
    },
    {
        height: 1.40,
        width: 1.20,
        price: 5285,
    },
    {
        height: 1.40,
        width: 1.35,
        price: 5843,
    },
    {
        height: 1.40,
        width: 1.50,
        price: 6346,
    },
    {
        height: 1.40,
        width: 1.80,
        price: 7595,
    },
    {
        height: 1.40,
        width: 2.10,
        price: 8655,
    },
    {
        height: 1.40,
        width: 2.40,
        price: 9657,
    },
    {
        height: 1.60,
        width: 0.60,
        price: 2639,
    },
    {
        height: 1.60,
        width: 0.70,
        price: 3043,
    },
    {
        height: 1.60,
        width: 0.80,
        price: 3337,
    },
    {
        height: 1.60,
        width: 0.90,
        price: 3966,
    },
    {
        height: 1.60,
        width: 1.05,
        price: 5129,
    },
    {
        height: 1.60,
        width: 1.20,
        price: 5675,
    },
    {
        height: 1.60,
        width: 1.35,
        price: 6282,
    },
    {
        height: 1.60,
        width: 1.50,
        price: 6827,
    },
    {
        height: 1.60,
        width: 1.80,
        price: 8189,
    },
    {
        height: 1.60,
        width: 2.10,
        price: 9344,
    },
    {
        height: 1.60,
        width: 2.40,
        price: 10432,
    },
    {
        height: 1.80,
        width: 0.60,
        price: 2793,
    },
    {
        height: 1.80,
        width: 0.70,
        price: 3228,
    },
    {
        height: 1.80,
        width: 0.80,
        price: 3549,
    },
    {
        height: 1.80,
        width: 0.90,
        price: 4223,
    },
    {
        height: 1.80,
        width: 1.05,
        price: 5474,
    },
    {
        height: 1.80,
        width: 1.20,
        price: 6065,
    },
    {
        height: 1.80,
        width: 1.35,
        price: 6718,
    },
    {
        height: 1.80,
        width: 1.50,
        price: 7307,
    },
    {
        height: 1.80,
        width: 1.80,
        price: 8785,
    },
    {
        height: 1.80,
        width: 2.10,
        price: 10030,
    },
    {
        height: 1.80,
        width: 2.40,
        price: 11207,
    },
    {
        height: 2.00,
        width: 0.60,
        price: 2980,
    },
    {
        height: 2.00,
        width: 0.70,
        price: 3462,
    },
    {
        height: 2.00,
        width: 0.80,
        price: 3812,
    },
    {
        height: 2.00,
        width: 0.90,
        price: 4544,
    },
    {
        height: 2.00,
        width: 1.05,
        price: 5899,
    },
    {
        height: 2.00,
        width: 1.20,
        price: 6547,
    },
    {
        height: 2.00,
        width: 1.35,
        price: 7261,
    },
    {
        height: 2.00,
        width: 1.50,
        price: 7903,
    },
    {
        height: 2.00,
        width: 1.80,
        price: 9522,
    },
    {
        height: 2.00,
        width: 2.10,
        price: 10881,
    },
    {
        height: 2.00,
        width: 2.40,
        price: 12169,
    },
    {
        height: 2.20,
        width: 0.60,
        price: 3136,
    },
    {
        height: 2.20,
        width: 0.70,
        price: 3654,
    },
    {
        height: 2.20,
        width: 0.80,
        price: 4027,
    },
    {
        height: 2.20,
        width: 0.90,
        price: 4801,
    },
    {
        height: 2.20,
        width: 1.05,
        price: 6244,
    },
    {
        height: 2.20,
        width: 1.20,
        price: 6935,
    },
    {
        height: 2.20,
        width: 1.35,
        price: 7697,
    },
    {
        height: 2.20,
        width: 1.50,
        price: 8383,
    },
    {
        height: 2.20,
        width: 1.80,
        price: 10119,
    },
    {
        height: 2.20,
        width: 2.10,
        price: 11569,
    },
    {
        height: 2.20,
        width: 2.40,
        price: 12944,
    },
    {
        height: 2.40,
        width: 0.60,
        price: 3324,
    },
    {
        height: 2.40,
        width: 0.70,
        price: 3886,
    },
    {
        height: 2.40,
        width: 0.80,
        price: 4618,
    },
    {
        height: 2.40,
        width: 0.90,
        price: 5122,
    },
    {
        height: 2.40,
        width: 1.05,
        price: 6672,
    },
    {
        height: 2.40,
        width: 1.20,
        price: 7414,
    },
    {
        height: 2.40,
        width: 1.35,
        price: 8235,
    },
    {
        height: 2.40,
        width: 1.50,
        price: 8979,
    },
    {
        height: 2.40,
        width: 1.80,
        price: 10858,
    },
    {
        height: 2.40,
        width: 2.10,
        price: 12421,
    },
    {
        height: 2.40,
        width: 2.40,
        price: 13907,
    },
    {
        height: 2.60,
        width: 0.60,
        price: 3480,
    },
    {
        height: 2.60,
        width: 0.70,
        price: 4078,
    },
    {
        height: 2.60,
        width: 0.80,
        price: 4847,
    },
    {
        height: 2.60,
        width: 0.90,
        price: 5378,
    },
    {
        height: 2.60,
        width: 1.05,
        price: 7021,
    },
    {
        height: 2.60,
        width: 1.20,
        price: 7804,
    },
    {
        height: 2.60,
        width: 1.35,
        price: 8673,
    },
    {
        height: 2.60,
        width: 1.50,
        price: 9461,
    },
    {
        height: 2.60,
        width: 1.80,
        price: 11455,
    },
    {
        height: 2.60,
        width: 2.10,
        price: 13109,
    },
    {
        height: 2.80,
        width: 0.60,
        price: 3681,
    },
    {
        height: 2.80,
        width: 0.70,
        price: 4323,
    },
    {
        height: 2.80,
        width: 0.80,
        price: 5144,
    },
    {
        height: 2.80,
        width: 0.90,
        price: 5711,
    },
    {
        height: 2.80,
        width: 1.05,
        price: 7460,
    },
    {
        height: 2.80,
        width: 1.20,
        price: 8304,
    },
    {
        height: 2.80,
        width: 1.35,
        price: 8229,
    },
    {
        height: 2.80,
        width: 1.50,
        price: 10070,
    },
    {
        height: 2.80,
        width: 1.80,
        price: 12207,
    },
    {
        height: 2.80,
        width: 2.10,
        price: 13976,
    },
    {
        height: 3.00,
        width: 0.60,
        price: 3832,
    },
    {
        height: 3.00,
        width: 0.70,
        price: 4511,
    },
    {
        height: 3.00,
        width: 0.80,
        price: 5372,
    },
    {
        height: 3.00,
        width: 0.90,
        price: 5970,
    },
    {
        height: 3.00,
        width: 1.05,
        price: 7806,
    },
    {
        height: 3.00,
        width: 1.20,
        price: 8691,
    },
    {
        height: 3.00,
        width: 1.35,
        price: 9665,
    },
    {
        height: 3.00,
        width: 1.50,
        price: 10550,
    },
    {
        height: 3.00,
        width: 1.80,
        price: 12803,
    },
    
];

export default woodMatrix;
