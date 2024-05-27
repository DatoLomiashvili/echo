<template>
    <div>
        <video ref="webcam" autoplay></video>
        <button @click="startWebcam">Start Webcam</button>
    </div>
</template>

<script>
export default {
    methods: {
        startWebcam() {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    this.$refs.webcam.srcObject = stream;
                })
                .catch(error => {
                    console.error('Error accessing webcam: ', error);
                });
        }
    }
};
</script>

<style scoped>
.webcam-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    max-width: 600px;
    margin: 0 auto;
}

video {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 10px;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: #fff;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}
</style>
