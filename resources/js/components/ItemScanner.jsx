import React, { useEffect } from 'react'


async function streamVideo() {
    const stream = await navigator.mediaDevices.getUserMedia({
        video: {
            facingMode: { ideal: 'environment' }
        },
        audio: false
    });
    const videoEl = document.querySelector('#scanner');
    videoEl.srcObject = stream;
    await videoEl.play();

    return videoEl;
}

function destroyVideo(videoEl) {
    const stream = videoEl.srcObject;
    const tracks = stream.getTracks();

    tracks.forEach(function (track) {
        track.stop();
    });

    videoEl.srcObject = null;
}

async function detectBarcode(videoEl, setScannedBarcode) {
    if ('BarcodeDetector' in window) {
        console.log('Barcode Detector supported!');
    } else {
        alert('Barcode Detector is not supported in this browser');
    }
    const barcodeDetector = new BarcodeDetector();

    const interval = setInterval(async () => {
        const barcodes = await barcodeDetector.detect(videoEl);
        if (barcodes.length > 0) {
            clearInterval(interval);
            destroyVideo(videoEl);
            setScannedBarcode(barcodes[0].rawValue);
        }
    }, 1000);

    return interval;
}

export default function ItemScanner({ setScannedBarcode }) {
    useEffect(() => {
        let interval;
        streamVideo().then((videoEl) => {
            interval = detectBarcode(videoEl, setScannedBarcode);
        });

        return () => {
            clearInterval(interval);
        }
    }, [])


    return (
        <div>
            <video id="scanner" />

        </div>
    )
}
