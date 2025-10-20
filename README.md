# Open Web UI API Provider
The Open WebUI API Provider is the [Open WebUI](https://openwebui.com/) Moodle [AI subsystem](https://docs.moodle.org/405/en/AI_subsystem) provider, thus enabling the usage of a custom/self hosted Open Web UI installation and leveraging the multiple AI models you install/develop/modify by running your LLMs software as Open WebUI backends.
Obviously the Open WebUI installation it's not a simple task and you need some specific hardware to get it work in a satisfiyng performance, but you'll own all the AI pipeline, controlling all the data path inside your company.
Sometime, somewhere it's needed...

## Why Open WebUI instead of so much more simple choice of "Big AI Providers"?

Open WebUI offers significant advantages for who want to be fully secure that no data is sent outside of the company scope. Open WebUI allows running many LLM backends on-premise in your physical/virtual HPC infrastructure with the feasibility of creating your custom models when you need one.

## Installation

To install this AI provider you can download the ZIP file and install from *Administration > Site administration > Plugins > Install plugins*, or you can unzip it in the `ai/provider` folder.
This provider requires Moodle LMS 4.5, the first version to include the AI subsystem.

You must provide an Open WebUI url where you installed it and an API Key enabled to use the OpenAI-like interface.

You need to configure what model you would like to use for each specific action.

## Tested models with version 1.0.0.0

We tested successully the following models:
- for text generation/summarization:
	- chat
	- qwen3:32b-fp16
	- qwen3:30b-a3b-thinking-2507-fp16
- for image generation
	- flux1-dev-fp8.safetensors

## Open WebUI requirements
For Open WebUI requirements, follow [Open WebUI Requirements](https://docs.openwebui.com/getting-started/).
At time of writing, our installation of Open WebUI runs on a single OpenStack VM, connected to two GraceHopper nodes working in bare/metal provisioned through a slurm context.
# moodle-aiprovider_openwebui
